<?php

namespace App\Http\Controllers;

use App\Models\ShiftChange;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShiftChangeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $shiftChange = ShiftChange::all();
            $shiftChangeData = [];

            foreach ($shiftChange as $data) {
                $shiftChangeData[] = [
                    'id' => $data->id,
                    'user_id' => $data->user_id,
                    'shift_id' => $data->shift_id,
                    'name' => $data->user->name,
                    'shift' => $data->shift->name,
                    'status' => $data->status,
                ];
            }

            return response()->json([
                'message' => 'Shift Change retrieved successfully',
                'data' => $shiftChangeData

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
                'user_id' => 'required|integer',
                'shift_id' => 'required|integer',
                'status' => 'required',
            ], [
                'user_id.required' => 'User ID is required',
                'user_id.integer' => 'User ID must be an integer',
                'shift_id.required' => 'Shift ID is required',
                'shift_id.integer' => 'Shift ID must be an integer',
                'status.required' => 'Status is required',
                // 'status.in' => 'Status must be requested, approved, or rejected',

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ]);
            }

            $shiftChange = new ShiftChange();
            $shiftChange->user_id = request('user_id');
            $shiftChange->shift_id = request('shift_id');
            $shiftChange->status = request('status');
            $shiftChange->save();



            return response()->json([
                'message' => 'Shift Change created successfully',
                'data' => $shiftChange
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
    public function show(ShiftChange $shiftChange)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShiftChange $shiftChange)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            $validator = Validator::make($request->all(), [
                'user_id' => 'required|integer',
                'shift_id' => 'required|integer',
                'status' => 'required',
            ], [
                'user_id.required' => 'User ID is required',
                'user_id.integer' => 'User ID must be an integer',
                'shift_id.required' => 'Shift ID is required',
                'shift_id.integer' => 'Shift ID must be an integer',
                'status.required' => 'Status is required',
                // 'status.in' => 'Status must be requested, approved, or rejected',

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ]);
            }

            $shiftChange =  ShiftChange::find($id);

            if (request('user_id')) {
                $shiftChange->user_id = request('user_id');
            }
            if (request('shift_id')) {
                $shiftChange->shift_id = request('shift_id');
            }
            if (request('status')) {
                $shiftChange->status = request('status');
            }

            $shiftChange->save();

            return response()->json([
                'message' => 'Shift Change updated successfully',
                'data' => $shiftChange
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
            $shiftChange = ShiftChange::find($id);
            $shiftChange->delete();
            return response()->json([
                'message' => 'Shift Change deleted successfully',
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
