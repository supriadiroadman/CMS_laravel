<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests\Categories\CreateCategoryRequest;
use App\Http\Requests\Categories\UpdateCategoryRequest;

class CategoryController extends Controller
{
    public function index()
    {
        return view('categories.index')->with('categories', Category::all());
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(CreateCategoryRequest $request)
    {
        Category::create([
            'name' => $request->name
        ]);

        session()->flash('success', 'Category created successfully');

        return redirect(route('categories.index'));
    }

    public function show($id)
    {
    }


    public function edit(Category $category)
    {
        return view('categories.create')->with('category', $category);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        // $category->name = $request->name;
        // $category->save();

        $category->update([
            'name' => $request->name
        ]);

        session()->flash('success', 'Category updated successfully');
        return redirect(route('categories.index'));
    }

    public function destroy(Category $category)
    {
        // Jika category dipakai oleh post (jumlah count lebih besar dari 0)
        // $category->posts->count() != 0     <- bisa juga logika tidak sama dengan 0 (!=0)
        if ($category->posts->count() > 0) {
            session()->flash('error', 'Category cannot be deleted because it has some posts');
            return redirect()->back();
        }

        $category->delete();

        session()->flash('success', 'Category deleted successfully');
        return redirect(route('categories.index'));
    }
}
