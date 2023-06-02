<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
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
        return response()->json(['success' => $orders], 200);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::all();
        return response()->json(['success' => $orders], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
            return response()->json(['error' => $validator->errors()], 401);
        }

        $order = Order::firstWhere('id', $id);
        $order['has_been_received'] = $request['has_been_received'];
        $order->save();
        return response()->json(['success' => $order, 'message' => 'order updated successfully'], 201);
    }
}
