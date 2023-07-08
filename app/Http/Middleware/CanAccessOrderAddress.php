<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\OrderAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CanAccessOrderAddress
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Validate the id
        $validator = Validator::make(['id' => $request->route('id')], [
            'id' => 'required|exists:orders_addresses,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Check if the user is an admin
        if (Auth::user() &&  Auth::user()->admin == 1) {
            return $next($request);
        }

        // Check if the user is the creator of the order address
        $orderAddressId = $request->route('id');

        $orderAddress = OrderAddress::find($orderAddressId);
        if ($orderAddress->user_id == Auth::user()->id) {
            return $next($request);
        }

        $errorResponse = [
            'error' => 'Unauthorized',
        ];
        return response()->json($errorResponse, 403);
    }
}
