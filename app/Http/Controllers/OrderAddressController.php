<?php

namespace App\Http\Controllers;

use App\Models\OrderAddress;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addresses = OrderAddress::paginate(24);

        return response()->json($addresses, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address_line' => 'required|max:191',
            'mobile_phone' => 'required|max:18',
            'city_id' => 'required|exists:cities,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = Auth::user();
        $order_address = OrderAddress::create([
            'address_line' => $request['address_line'],
            'mobile_phone' => $request['mobile_phone'],
            'city_id' => $request['city_id'],
            'user_id' => $user['id'],
        ]);

        return response()->json(['message' => 'Order Address created successfully', 'data' => $order_address], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $address = OrderAddress::find($id);

        if ($address == null) {
            return response()->json(['error' => 'Order Address not found'], Response::HTTP_NOT_FOUND);
        }

        return response(['data' => $address], 200);
    }
}
