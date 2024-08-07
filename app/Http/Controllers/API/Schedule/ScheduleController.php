<?php

namespace App\Http\Controllers\API\Schedule;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $schedule = Schedule::all();
            return response()->json([
                'message' => 'Schedule retrieved successfully',
                'data' => $schedule
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
                'date' => 'required',
            ], [
                'name.required' => 'Name is required',
                'name.string' => 'Name must be a string',
                'date.required' => 'Date is required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 400);
            }

            $schedule = new Schedule();
            $schedule->name = request('name');
            $schedule->date = request('date');
            $schedule->save();

            return response()->json([
                'message' => 'Schedule created successfully',
                'data' => $schedule
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
                'name' => 'required|string',
                'date' => 'required',
            ], [
                'name.required' => 'Name is required',
                'name.string' => 'Name must be a string',
                'date.required' => 'Date is required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 400);
            }

            $schedule = Schedule::find($id);
            if (request('name')) {
                $schedule->name = request('name');
            }
            if (request('date')) {
                $schedule->date = request('date');
            }
            $schedule->save();

            return response()->json([
                'message' => 'Schedule updated successfully',
                'data' => $schedule
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
            $schedule = Schedule::find($id);
            $schedule->delete();
            return response()->json([
                'message' => 'Schedule deleted successfully',
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
