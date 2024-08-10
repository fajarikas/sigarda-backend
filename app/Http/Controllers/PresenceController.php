<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PresenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $presence = Presence::orderBy('created_at', 'asc')->get();

            foreach ($presence as $data) {
                $presenceData[] = [
                    'id' => $data->id,
                    'user' => $data->user->name,
                    'user_id' => $data->user_id,
                    'attendance' => $data->attendance,
                    'check_in' => $data->check_in,
                    'check_out' => $data->check_out,
                    'date' => $data->created_at->format('Y-m-d'),
                ];
            }
            return response()->json([
                'message' => 'Presence retrieved successfully',
                'data' => $presenceData
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
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|integer',
                'attendance' => 'required',

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ]);
            }

            $presence = new Presence();
            $presence->user_id = request('user_id');
            $presence->attendance = request('attendance');
            $presence->check_in = request('check_in');
            $presence->check_out = request('check_out');
            $presence->save();

            return response()->json([
                'message' => 'Presence created successfully',
                'data' => $presence
            ]);
        } catch (Exception $e) {
            return response()->json([
                'errors' => [
                    'message' => $e->getMessage()
                ]
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Presence $presence)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Presence $presence)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|integer',
                'attendance' => 'required',
                'check_in' => 'nullable',
                'check_out' => 'nullable',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422); // Status code 422 for Unprocessable Entity
            }

            $presence = Presence::find($id);

            if (!$presence) {
                return response()->json([
                    'error' => 'Presence not found'
                ], 404); // Status code 404 for Not Found
            }

            $presence->user_id = $request->input('user_id');
            $presence->attendance = $request->input('attendance');
            $presence->check_in = $request->input('check_in');
            $presence->check_out = $request->input('check_out');
            $presence->save();

            return response()->json([
                'message' => 'Presence updated successfully',
                'data' => $presence
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => [
                    'message' => $e->getMessage()
                ]
            ], 500); // Status code 500 for Internal Server Error
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Presence $presence)
    {
        try {
            $presence->delete();
            return response()->json([
                'message' => 'Presence deleted successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'errors' => [
                    'message' => $e->getMessage()
                ]
            ]);
        }
    }
}
