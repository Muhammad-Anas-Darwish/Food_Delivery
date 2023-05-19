<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $foods = Food::all();
        return response()->json(['success', $foods], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:128',
            'price' => 'required',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $food = Food::create([
            'title' => $request['title'],
            'price' => $request['price'],
            'is_active' => $request['is_active'],
            'description' => $request['description'],
            'category_id' => $request['category_id'],
        ]);

        return response()->json(['success', $food], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $food = Food::firstWhere('slug', $slug);
        return response(['success', $food], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $slug)
    {
        $food = Food::firstWhere('slug', $slug)->update($request->all());
        return response()->json(['success', $food], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        $food = Food::firstWhere('slug', $slug)->delete();
        return response()->json(['success' => $food], 202);
    }
}
