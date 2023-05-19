<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = City::all();
        return response()->json(['success', $cities], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:32',
            'country_id' => 'required|exists:countries,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $city = City::create([
            'title' => $request['title'],
            'country_id' => $request['country_id'],
        ]);

        return response()->json(['success' => $city], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $city = City::find($id);
        return response()->json(['success' => $city], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $city = City::find($id);
        $city['title'] = $request['title'];
        $city['country_id'] = $request['country_id'];
        $city->save();
        return response(['success' => $city], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $city = City::find($id)->delete();
        return response()->json(['success' => $city], 202);
    }
}
