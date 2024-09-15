<?php

namespace App\Http\Controllers\API\Schedule;

use App\Http\Controllers\Controller;
use App\Models\ScheduledUser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScheduledUserController extends Controller
{

    public function index()
    {
        try {
            $scheduledUser = ScheduledUser::all();

            $scheduledUserData = [];

            foreach ($scheduledUser as $data) {
                $scheduledUserData[] = [
                    'id' => $data->id,
                    'schedule_id' => $data->schedule_id,
                    'user_id' => $data->user_id,
                    'schedule' => $data->schedule ? $data->schedule->name : null,
                    'user' => $data->user->name,
                ];
            }
            return response()->json([
                'message' => 'Scheduled User retrieved successfully',
                'data' => $scheduledUserData
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
                'schedule_id' => 'nullable',
                'user_id' => 'required|integer',
            ], [
                // 'schedule_id.integer' => 'Schedule ID must be an integer if provided',
                'user_id.required' => 'User ID is required',
                'user_id.integer' => 'User ID must be an integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 400);
            }

            $scheduledUser = new ScheduledUser();
            $scheduledUser->schedule_id = $request->input('schedule_id', null);
            $scheduledUser->user_id = $request->input('user_id');
            $scheduledUser->save();

            return response()->json([
                'message' => 'Scheduled User created successfully',
                'data' => $scheduledUser
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => [
                    'message' => $e->getMessage(),
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
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'schedule_id' => 'integer',
                'user_id' => 'required|integer',
            ], [
                // 'schedule_id.required' => 'Schedule ID is required',
                'schedule_id.integer' => 'Schedule ID must be an integer',
                'user_id.required' => 'User ID is required',
                'user_id.integer' => 'User ID must be an integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 400);
            }

            $scheduledUser = ScheduledUser::find($id);

            if (request('schedule_id')) {
                $scheduledUser->schedule_id = request('schedule_id');
            }
            if (request('user_id')) {
                $scheduledUser->user_id = request('user_id');
            }

            $scheduledUser->save();

            return response()->json([
                'message' => 'Scheduled User updated successfully',
                'data' => $scheduledUser
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
            $scheduledUser = ScheduledUser::find($id);
            $scheduledUser->delete();

            return response()->json([
                'message' => 'Scheduled User deleted successfully',
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
