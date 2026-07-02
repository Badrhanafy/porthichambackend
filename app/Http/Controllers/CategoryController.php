<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(Category::with('projects')->latest()->get());
    }

    public function store (Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'coverpath' => 'nullable|file|mimes:jpg,jpeg,png,webp',
        ]);

        if ($request->hasFile('coverpath')) {
            $coverPath = $request->file('coverpath')->store('category_covers', 'public');
        } else {
            $coverPath = null;
        }

        $category = Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'coverpath' => $coverPath,
        ]);

        return response()->json([
            'message' => 'Category created successfully',
            'category' => $category
        ], 201);
    }
}
