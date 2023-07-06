<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
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
