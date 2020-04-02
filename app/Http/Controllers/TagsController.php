<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Http\Requests\Tags\CreateTagRequest;
use App\Http\Requests\Tags\UpdateTagRequest;

class TagsController extends Controller
{
  public function index()
  {
    return view('tags.index')->with('tags', Tag::all());
  }

  public function create()
  {
    return view('tags.create');
  }

  public function store(CreateTagRequest $request)
  {
    Tag::create([
      'name' => $request->name
    ]);

    session()->flash('success', 'Tag created successfully');

    return redirect(route('tags.index'));
  }

  public function show($id)
  {
  }


  public function edit(Tag $tag)
  {
    return view('tags.create')->with('tag', $tag);
  }

  public function update(UpdateTagRequest $request, Tag $tag)
  {
    // $Tag->name = $request->name;
    // $Tag->save();

    $tag->update([
      'name' => $request->name
    ]);

    session()->flash('success', 'Tag updated successfully');
    return redirect(route('tags.index'));
  }

  public function destroy(Tag $tag)
  {
    // Jika tag dipakai oleh post (jumlah count lebih besar dari 0)
    // $tag->posts->count() != 0     <- bisa juga logika tidak sama dengan 0 (!=0)
    if ($tag->posts->count() > 0) {
      session()->flash('error', 'Tag cannot be deleted because it has some posts');
      return redirect()->back();
    }

    $tag->delete();

    session()->flash('success', 'Tag deleted successfully');
    return redirect(route('tags.index'));
  }
}
