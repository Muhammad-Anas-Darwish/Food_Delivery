<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Cviebrock\EloquentSluggable\Sluggable;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json(['data' => $categories], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:128',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $category = Category::create([
            'title' => $request["title"],
        ]);

        return response()->json(['message' => 'Category stored successfully', 'data' => $category], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        // Validate the slug
        $validator = Validator::make(['slug' => $slug], [
            'slug' => 'required|exists:categories,slug'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $category = Category::firstWhere('slug', $slug);
        return response()->json($category, 200);
        // return response()->json(compact('category'), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $slug)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Validate the slug
        $validator = Validator::make(['slug' => $slug], [
            'slug' => 'required|exists:categories,slug'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $category = Category::firstWhere('slug', $slug);
        $category['title'] = $request['title'];
        $category->save();
        return response()->json(['message' => 'Category updated successfully', 'data' => $category], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        // Validate the slug
        $validator = Validator::make(['slug' => $slug], [
            'slug' => 'required|exists:categories,slug'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $category = Category::firstWhere('slug', $slug)->delete();
        return response()->json(['message' => 'Category deleted successfully', 'data' => $category], 202);
    }
}
