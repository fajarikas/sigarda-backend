<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $shift = Shift::all();
            return response()->json([
                'message' => 'Shift retrieved successfully',
                'data' => $shift
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
                'name' => 'required|string',
                'start' => 'required|date_format:H:i:s',
                'end' => 'required|date_format:H:i:s',
            ], [
                'name.required' => 'Name is required',
                'name.string' => 'Name must be a string',
                'start.required' => 'Start time is required',
                'end.required' => 'End time is required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ]);
            }

            $shift = new Shift();
            $shift->name = request('name');
            $shift->start = request('start');
            $shift->end = request('end');
            $shift->save();

            return response()->json([
                'message' => 'Shift created successfully',
                'data' => $shift
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
     * Display the specified resource.
     */
    public function show(Shift $shift)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shift $shift)
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
                'name' => 'required|string',
                'start' => 'required|date_format:H:i:s',
                'end' => 'required|date_format:H:i:s',
            ], [
                'name.required' => 'Name is required',
                'name.string' => 'Name must be a string',
                'start.required' => 'Start time is required',
                'end.required' => 'End time is required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ]);
            }

            $shift = Shift::find($id);
            if (request('name')) {
                $shift->name = request('name');
            }
            if (request('start')) {
                $shift->start = request('start');
            }
            if (request('end')) {
                $shift->end = request('end');
            }
            $shift->save();

            return response()->json([
                'message' => 'Shift updated successfully',
                'data' => $shift
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $shift = Shift::find($id);
            $shift->delete();

            return response()->json([
                'message' => 'Shift deleted successfully',
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
