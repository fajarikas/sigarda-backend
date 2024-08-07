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
            $presence = Presence::all();

            foreach ($presence as $data) {
                $presenceData[] = [
                    'user' => $data->user->name,
                    'status' => $data->status,
                    'check_in' => $data->check_in,
                    'check_out' => $data->check_out,
                ];
            }
            return response()->json([
                'message' => 'Presence retrieved successfully',
                'presence' => $presenceData
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
                'status' => 'required|in:Hadir, Tidak Hadir',
                'check_in' => 'required|date_format:H:i:s',
                'check_out' => 'required|date_format:H:i:s',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ]);
            }

            $presence = new Presence();
            $presence->user_id = request('user_id');
            $presence->status = request('status');
            $presence->check_in = request('check_in');
            $presence->check_out = request('check_out');
            $presence->save();

            return response()->json([
                'message' => 'Presence created successfully',
                'presence' => $presence
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
    public function update(Request $request, Presence $presence)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|integer',
                'status' => 'required|in:Hadir, Tidak Hadir',
                'check_in' => 'required|date_format:H:i:s',
                'check_out' => 'required|date_format:H:i:s',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ]);
            }

            $presence->user_id = request('user_id');
            $presence->status = request('status');
            $presence->check_in = request('check_in');
            $presence->check_out = request('check_out');

            if (request('user_id')) $presence->user_id = request('user_id');
            if (request('status')) $presence->status = request('status');
            if (request('check_in')) $presence->check_in = request('check_in');
            if (request('check_out')) $presence->check_out = request('check_out');
            $presence->save();

            return response()->json([
                'message' => 'Presence updated successfully',
                'presence' => $presence
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
