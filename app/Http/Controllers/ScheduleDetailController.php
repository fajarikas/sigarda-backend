<?php

namespace App\Http\Controllers;

use App\Models\ScheduleDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ScheduleDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function getByScheduleId($schedule_id)
    {
        try {
            $scheduleDetails = ScheduleDetail::where('schedule_id', $schedule_id)->get();

            if ($scheduleDetails->isEmpty()) {
                return response()->json([
                    'message' => 'No schedule details found for this schedule',
                    'data' => []
                ]);
            }

            return response()->json([
                'message' => 'Schedule details retrieved successfully',
                'data' => $scheduleDetails
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => [
                    'message' => $e->getMessage(),
                ]
            ], 500);
        }
    }

    public function index()
    {
        try {
            $scheduleDetails = ScheduleDetail::all();
            return response()->json([
                'message' => 'Schedule details retrieved successfully',
                'data' => $scheduleDetails
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'schedule_id' => 'required|exists:schedules,id',
                'date' => 'required|date',
                'shift' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 400);
            }

            // Buat jadwal baru
            $scheduleDetail = ScheduleDetail::create($request->all());

            // Log untuk memastikan bahwa $scheduleDetail berisi ID
            Log::info('New ScheduleDetail created with ID: ' . $scheduleDetail->id);

            // Pastikan ID dikembalikan dalam response
            return response()->json([
                'message' => 'Schedule detail created successfully',
                'data' => $scheduleDetail
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
        try {
            $scheduleDetail = ScheduleDetail::findOrFail($id);
            return response()->json([
                'message' => 'Schedule detail retrieved successfully',
                'data' => $scheduleDetail
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'schedule_id' => 'sometimes|required|exists:schedules,id',
                'date' => 'sometimes|required|date',
                'shift' => 'sometimes|required|string',
            ], [
                'schedule_id.exists' => 'Scheduled user does not exist',
                'date.date' => 'Date must be a valid date',
                'shift.string' => 'Shift must be a string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 400);
            }

            $scheduleDetail = ScheduleDetail::findOrFail($id);
            $scheduleDetail->update($request->all());

            return response()->json([
                'message' => 'Schedule detail updated successfully',
                'data' => $scheduleDetail
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
            $scheduleDetail = ScheduleDetail::findOrFail($id);
            $scheduleDetail->delete();
            return response()->json([
                'message' => 'Schedule detail deleted successfully',
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
