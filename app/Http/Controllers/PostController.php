<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Post;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Http\Requests\Posts\CreatePostsRequest;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('verifyCategoriesCount')->only(['create', 'store']);
    }

    public function index()
    {
        return view('posts.index')->with('posts', Post::all());
    }

    public function create()
    {
        return view('posts.create')->with('categories', Category::all())->with('tags', Tag::all());
    }


    public function store(CreatePostsRequest $request)
    {
        $image = $request->image->store('posts');

        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'image' => $image,
            'published_at' => $request->published_at,
            'category_id' => $request->category_id,
            'user_id' => auth()->user()->id,
        ]);

        if ($request->tags) {
            $post->tags()->attach($request->tags);
        }

        session()->flash('success', 'Post created successfully');
        return redirect(route('posts.index'));
    }


    public function show($id)
    {
    }

    public function edit(Post $post)
    {
        return view('posts.create')->with('post', $post)->with('categories', Category::all())->with('tags', Tag::all());
    }


    public function update(UpdatePostRequest $request, Post $post)
    {
        // Ambil inputan form hanya di method only (kecuali image)
        $data = $request->only(['title', 'description', 'content', 'published_at', 'category_id']);

        // Jika ganti image
        if ($request->hasFile('image')) {
            // Ambil image dari form simpan ke posts 
            $image = $request->image->store('posts');

            // Hapus file image lama dari database
            // menggunakan method dari Model Post
            // Storage::delete($post->image);
            $post->deleteImage();

            // Isi field image jika ganti gambar lalu input ke property $data array
            $data['image'] = $image;
        }

        // Hapus relasi post dan tag (tabel post_tag)
        if ($request->tags) {
            $post->tags()->sync($request->tags);
        }

        // Update table posts dari data $data array
        $post->update($data);

        session()->flash('success', 'Post updated successfully');
        return redirect(route('posts.index'));
    }

    public function destroy($id)
    {
        $post = Post::withTrashed()->where('id', $id)->firstOrFail();
        if ($post->trashed()) {
            // Hapus file image lama dari database
            // menggunakan method dari Model Post
            // Storage::delete($post->image);
            $post->deleteImage();

            $post->forceDelete();
        } else {
            $post->delete();
        }

        session()->flash('success', 'Post deleted successfully');
        return redirect(route('posts.index'));
    }

    public function trashed()
    {
        $trashed = Post::onlyTrashed()->get();

        // return view('posts.index')->withPosts($trashed);
        return view('posts.index')->with('posts', $trashed);
    }

    public function restore($id)
    {
        // $post = Post::withTrashed()->where('id', $id)->firstOrFail();
        $post = Post::onlyTrashed()->where('id', $id)->firstOrFail();
        $post->restore();

        session()->flash('success', 'Post restored successfully');
        return redirect()->back();
    }
}
