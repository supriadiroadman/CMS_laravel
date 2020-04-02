<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Post;
use App\Category;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $search = request()->query('search');

        if ($search) {
            $posts = Post::where('title', 'LIKE', "%{$search}%")->paginate(1);
            // $posts = Post::published()->where('title', 'LIKE', "%{$search}%")->paginate(1);
        } else {
            $posts = Post::paginate(2);
            // $posts = Post::published()->paginate(2);
        }

        return view('welcome')
            ->with('categories', Category::all())
            ->with('tags', Tag::all())
            ->with('posts', $posts);
    }
}
