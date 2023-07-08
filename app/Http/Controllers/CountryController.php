<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $country = Country::all();
        return response()->json(['data' => $country], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:32',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator], 400);
        }

        $country = Country::create([
            'title' => $request['title'],
        ]);

        return response()->json(['data' => $country, 'message' => 'Country created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $country = Country::find($id);

        if ($country === null) {
            return response()->json(['error' => "Country not found"], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['data' => $country], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        
        $country = Country::find($id);

        if ($country === null) {
            return response()->json(['error' => "Country not found"], Response::HTTP_NOT_FOUND);
        }

        $country['title'] = $request['title'];
        $country->save();
        return response()->json(['data' => $country, 'message' => 'Country updated successfully'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $country = Country::find($id);

        if ($country == null) {
            return response()->json(['error' => 'Country not found'], Response::HTTP_NOT_FOUND);
        }

        $country->delete();

        return response()->json(['message' => 'Country deleted successfully'], 201);

    }
}
