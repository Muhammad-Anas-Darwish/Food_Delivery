<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = City::all();
        return response()->json(['data', $cities], 200);
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
            return response()->json(['error' => $validator->errors()], 400);
        }

        $city = City::create([
            'title' => $request['title'],
            'country_id' => $request['country_id'],
        ]);

        return response()->json(['message' => 'City created successfully', 'data' => $city], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $city = City::find($id);

        if ($city === null) {
            return response()->json(['error' => "City not found"], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['data' => $city], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'country_id' => 'required|exists:countries,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $city = City::find($id);

        if ($city === null) {
            return response()->json(['error' => "City not found"], Response::HTTP_NOT_FOUND);
        }

        $city['title'] = $request['title'];
        $city['country_id'] = $request['country_id'];
        $city->save();
        return response()->json(['message' => 'City updated successfully', 'data' => $city], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $city = City::find($id);

        if ($city === null) {
            return response()->json(['error' => "City not found"], Response::HTTP_NOT_FOUND);
        }

        $city->delete();
        return response()->json(['message' => 'City deleted successfully'], 202);
    }
}
