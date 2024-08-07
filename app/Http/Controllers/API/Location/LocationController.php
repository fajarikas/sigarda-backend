<?php

namespace App\Http\Controllers\API\Location;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $location = Location::all();
            return response()->json([
                'message' => 'Location retrieved successfully',
                'data' => $location
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => [
                    "message" => $e->getMessage(),
                ]
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'office_name' => 'required|string',
                'latitude'  => 'required|integer',
                'longitude' => 'required|integer',
            ], [
                'office_name.required' => 'Office Name is required',
                'office_name.string' => 'Office Name must be a string',
                'latitude.required' => 'Latitude is required',
                'latitude.integer' => 'Latitude must be an integer',
                'longitude.required' => 'Longitude is required',
                'longitude.integer' => 'Longitude must be an integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 400);
            }

            $location = new Location();
            $location->office_name = request('office_name');
            $location->latitude = request('latitude');
            $location->longitude = request('longitude');
            $location->save();

            return response()->json([
                'data' => $location,
                'message' => 'Location created successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => [
                    "message" => $e->getMessage(),
                ]
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'office_name' => 'required|string',
                'latitude'  => 'required|integer',
                'longitude' => 'required|integer',
            ], [
                'office_name.required' => 'Office Name is required',
                'office_name.string' => 'Office Name must be a string',
                'latitude.required' => 'Latitude is required',
                'latitude.integer' => 'Latitude must be an integer',
                'longitude.required' => 'Longitude is required',
                'longitude.integer' => 'Longitude must be an integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 400);
            }

            $location =  Location::find($id);
            if (request('office_name')) $location->office_name = request('office_name');
            if (request('latitude')) $location->latitude = request('latitude');
            if (request('longitude')) $location->longitude = request('longitude');

            $location->save();

            return response()->json([
                'data' => $location,
                'message' => 'Location created successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => [
                    "message" => $e->getMessage(),
                ]
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $location = Location::find($id);
            $location->delete();
            return response()->json([
                'message' => 'Location deleted successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => [
                    "message" => $e->getMessage(),
                ]
            ], 500);
        }
    }
}
