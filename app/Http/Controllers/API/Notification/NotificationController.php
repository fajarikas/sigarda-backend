<?php

namespace App\Http\Controllers\API\Notification;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $notification = Notification::all();

            $notificationData = [];

            foreach ($notification as $data) {
                $notificationData[] = [
                    'user' => $data->user->name,
                    'type' => $data->type,
                    'message' => $data->message,
                ];
            }
            return response()->json([
                'message' => 'Notification retrieved successfully',
                'data' => $notificationData
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
                'type' => 'required|in:notification,announcement',
                'message' => 'required|string',
            ], [
                'user_id.required' => 'User ID is required',
                'user_id.integer' => 'User ID must be an integer',
                'type.required' => 'Type is required',
                'type.in' => 'Type is must be notification or announcement',
                'message.required' => 'Message is required',
                'message.string' => 'Message must be a string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 400);
            }

            $notification = new Notification();
            $notification->user_id = request('user_id');
            $notification->type = request('type');
            $notification->message = request('message');
            $notification->save();

            return response()->json([
                'message' => 'Notification created successfully',
                'data' => $notification
            ], 201);
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
                'user_id' => 'required|integer',
                'type' => 'required|in:notification,announcement',
                'message' => 'required|string',
            ], [
                'user_id.required' => 'User ID is required',
                'user_id.integer' => 'User ID must be an integer',
                'type.required' => 'Type is required',
                'type.in' => 'Type is must be notification or announcement',
                'message.required' => 'Message is required',
                'message.string' => 'Message must be a string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 400);
            }

            $notification = Notification::find($id);

            if (request('user_id')) {
                $notification->user_id = request('user_id');
            }

            if (request('type')) {
                $notification->type = request('type');
            }

            if (request('message')) {
                $notification->message = request('message');
            }

            $notification->save();

            return response()->json([
                'message' => 'Notification updated successfully',
                'data' => $notification
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
            $notification = Notification::find($id);
            $notification->delete();

            return response()->json([
                'message' => 'Notification deleted successfully',
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
