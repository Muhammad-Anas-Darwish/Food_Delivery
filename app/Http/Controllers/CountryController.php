<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $country = Country::all();
        return response()->json(['success' => $country], 200);
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
            return response()->json(['error' => $validator]);
        }

        $country = Country::create([
            'title' => $request['title'],
        ]);

        return response()->json(['success' => $country], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $country = Country::find($id);
        return response()->json($country, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $country = Country::find($id);
        $country['title'] = $request['title'];
        $country->save();
        return response()->json(['success' => $country], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $country = Country::find($id)->delete();
        return response()->json(['success' => $country], 201);
    }
}
