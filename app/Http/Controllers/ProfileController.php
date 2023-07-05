<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'number_mobile' => 'required|numeric|min:10',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $profile = Profile::create([
            'user_id' => $user['id'],
            'number_mobile' => $request["number_mobile"]
        ]);

        return response()->json(['message' => 'Profile created successfully', 'data' => $profile], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = Auth::user();
        $profile = Profile::all()->where('user_id', '=', $user['id']);
        return response()->json(['data' => $profile], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $profile = Profile::all()->where('user_id', '=', $user['id'])->first();
        $profile['number_mobile'] = $request['number_mobile'];
        $profile->save();
        return response()->json(['message' => 'Profile updated successfully', 'data' => $profile], 201);
    }
}
