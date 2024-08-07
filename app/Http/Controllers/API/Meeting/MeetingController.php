<?php

namespace App\Http\Controllers\API\Meeting;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\r;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $meeting = Meeting::all();

            foreach ($meeting as $data) {
                $meetingData[] = [
                    'project' => $data->project->name,
                    'user' => $data->user->name,
                    'description' => $data->description,
                    'date' => $data->date,
                    'type' => $data->type,
                    'place' => $data->place,
                ];
            }

            return response()->json([
                'message' => 'Meeting retrieved successfully',
                'data' => $meetingData
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
                'project_id' => 'required|integer',
                'user_id' => 'required|integer',
                'description' => 'required|string',
                'date' => 'required|date',
                'type' => 'required|in:Online,Offline',
                'place' => 'required',
            ], [
                'project_id.required' => 'Project ID is required',
                'project_id.integer' => 'Project ID must be an integer',
                'user_id.required' => 'User ID is required',
                'user_id.integer' => 'User ID must be an integer',
                'description.required' => 'Description is required',
                'description.string' => 'Description must be a string',
                'date.required' => 'Date is required',
                'date.date' => 'Date must be a date',
                'type.required' => 'Type is required',
                'type.in' => 'Type must be either Online or Offline',
                'place.required' => 'Place is required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors()
                ], 400);
            }

            $meeting = new Meeting();
            $meeting->project_id = request('project_id');
            $meeting->user_id = request('user_id');
            $meeting->description = request('description');
            $meeting->date = request('date');
            $meeting->type = request('type');
            $meeting->place = request('place');
            $meeting->save();

            return response()->json([
                'message' => 'Meeting created successfully',
                'data' => $meeting
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
    public function show(string $r)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $r)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'project_id' => 'required|integer',
                'user_id' => 'required|integer',
                'description' => 'required|string',
                'date' => 'required|date',
                'type' => 'required|in:Online,Offline',
                'place' => 'required',
            ], [
                'project_id.required' => 'Project ID is required',
                'project_id.integer' => 'Project ID must be an integer',
                'user_id.required' => 'User ID is required',
                'user_id.integer' => 'User ID must be an integer',
                'description.required' => 'Description is required',
                'description.string' => 'Description must be a string',
                'date.required' => 'Date is required',
                'date.date' => 'Date must be a date',
                'type.required' => 'Type is required',
                'type.in' => 'Type must be either Online or Offline',
                'place.required' => 'Place is required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors()
                ], 400);
            }

            $meeting = Meeting::find($id);
            if (request('project_id')) {
                $meeting->project_id = request('project_id');
            }
            if (request('user_id')) {
                $meeting->user_id = request('user_id');
            }
            if (request('description')) {
                $meeting->description = request('description');
            }
            if (request('date')) {
                $meeting->date = request('date');
            }
            if (request('type')) {
                $meeting->type = request('type');
            }
            if (request('place')) {
                $meeting->place = request('place');
            }

            $meeting->save();

            return response()->json([
                'message' => 'Meeting updated successfully',
                'data' => $meeting
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
            $meeting = Meeting::find($id);
            $meeting->delete();

            return response()->json([
                'message' => "Meeting deleted successfullly",
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => [
                    "message" => $e->getMessage(),
                ]
            ], 500);
        }
    }
}
