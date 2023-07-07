<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Display a listing of the carts has been ordered.
     */
    public function index(Request $request)
    {
        $carts = Cart::where('been_ordered', 1);

        if ($request->has('filter')) {
            $filters = $request->get('filter');

            // Apply individual filters
            if (isset($filters['has_been_received'])) {
                $carts = $carts->whereHas('order', function ($query) use($filters) {
                    $query->where('has_been_received', $filters['has_been_received']);
                });
            }
        }

        return response()->json($carts->paginate(24), 200);
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
            return response()->json(['message' => 'Cart created successfully'], 201);
        } else {
            return response()->json(['message' => 'The cart already exists!'], 409);
        }
    }

    /**
     * Display the specified resource.
     */
    public function getMyCart()
    {
        $user = Auth::user();
        $cart = Cart::firstWhere(['user_id' => $user['id'], 'been_ordered' => false]);
        if ($cart === null)
            return response()->json(['error' => "There is no cart!"], 404);

        $cart = $cart->orderBy('created_at', 'desc')->get()->first();
        return response()->json(['data' => $cart], 200);
    }
}
