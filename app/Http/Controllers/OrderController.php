<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource for user.
     */
    public function getOrders()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user['id']);
        return response()->json(['data' => $orders], 200);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::all();
        return response()->json(['data' => $orders], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'has_been_received' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $order = Order::find($id);

        if ($order == null) {
            return response()->json(['error' => 'Order not found'], Response::HTTP_NOT_FOUND);
        }

        $order['has_been_received'] = $request['has_been_received'];
        $order->save();
        return response()->json(['data' => $order, 'message' => 'Order updated successfully'], 201);
    }
}
