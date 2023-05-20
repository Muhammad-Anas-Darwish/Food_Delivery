<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carts = Cart::all();
        return response()->json(['success', $carts], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $user = Auth::user();

        $cart = Cart::firstOrCreate([
            'user_id' => $user['id'],
            'been_ordered' => false,
        ]);

        if ($cart->wasRecentlyCreated) {
            return response()->json(['message' => 'Item created successfully'], 201);
        } else {
            return response()->json(['message' => 'The item already exists!'], 409);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = Auth::user();
        $cart = Cart::firstWhere(['user_id' => $user['id'], 'been_ordered' => false]);
        if ($cart === null)
            return response()->json(['error' => "There is no cart!"], 404);

        $cart = $cart->orderBy('created_at', 'desc')->get()->first();
        return response()->json(['success' => $cart], 200);
    }
}
