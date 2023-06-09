<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\FoodCart;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FoodCartController extends Controller
{
    /**
     * Display a listing of the cart items.
     */
    public function getCartItems()
    {
        $user = Auth::user();

        // Get the last cart for the user
        $cart = Cart::firstOrCreate(['user_id' => $user['id'], 'been_ordered' => false]);

        // Get all food items in the last cart and their quantities
        $food_cart_items = FoodCart::where('cart_id', $cart->id)->with('food')->get();

        return response()->json(['data' => $food_cart_items], 200);
    }

    /**
     * Store a newly created resource in storage.
     * Request should has food_id, quantity
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'food_id' => 'required|exists:foods,id',
            'quantity' => 'required|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = Auth::user();

        // Get the last cart for the user
        $cart = Cart::firstOrCreate(['user_id' => $user['id'], 'been_ordered' => false]);

        // Get food item in the last cart and their quantitiy
        $food_cart_item = FoodCart::where(['cart_id' => $cart->id, 'food_id' => $request['food_id']])->first();

        if ($food_cart_item) { // item is already exist
            $food_cart_item['quantity'] += $request['quantity']; // add new quantity to old quantity
            $food_cart_item->save();
        }
        else {
            $food_cart_item = FoodCart::create([
                'cart_id' => $cart['id'],
                'food_id' => $request['food_id'],
                'quantity' => $request['quantity'],
            ]);
        }
        return response()->json(['message' => 'Food cart item created successfully', 'data' => $food_cart_item], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = Auth::user();
        $cart = Cart::firstOrCreate(['user_id' => $user['id'], 'been_ordered' => false]);

        // Get food item in the last cart and their quantitiy
        $food_cart_item = FoodCart::where(['cart_id' => $cart->id, 'id' => $id])->first();

        if ($food_cart_item == null) {
            return response()->json(['error' => 'Food Cart not found'], Response::HTTP_NOT_FOUND);
        }

        $food_cart_item['quantity'] += $request['quantity'];

        if ($food_cart_item['quantity'] <= 0) { // if quantity is negative delete food_cart_item
            $food_cart_item->delete();
            return response()->json(['data' => $food_cart_item, 'message' => 'no quantity in this food cart!'], 202);
        }

        $food_cart_item->save();

        return response()->json(['message' => 'Food cart updated successfully', 'data' => $food_cart_item], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $cart = Cart::firstOrCreate(['user_id' => $user['id'], 'been_ordered' => false]);

        // Get food item in the last cart and their quantitiy
        $food_cart_item = FoodCart::firstWhere(['id' => $id, 'cart_id' => $cart->id]);

        if ($food_cart_item === null) {
            return response()->json(['error' => 'Food Cart not found'], Response::HTTP_NOT_FOUND);
        }

        $food_cart_item->delete();

        return response()->json(['message' => 'Food cart deleted successfully'], 202);
    }
}
