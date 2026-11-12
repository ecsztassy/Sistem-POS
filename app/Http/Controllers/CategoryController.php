<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        return view('categories.index', ['categories' => Category::withCount('items')->orderBy('name')->get()]);
    }

    public function store(CategoryRequest $request)
    {
        Category::create($request->validated());

        return back()->with('success', 'Kategori ditambahkan.');
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return back()->with('success', 'Kategori diperbarui.');
    }

    public function destroy(Category $category)
    {
        DB::transaction(function () use ($category) {
            $category->items()->delete();
            $category->delete();
        });

        return back()->with('success', 'Kategori dan barang di dalamnya diarsipkan.');
    }
}
