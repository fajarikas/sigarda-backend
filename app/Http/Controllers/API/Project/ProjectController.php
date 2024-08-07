<?php

namespace App\Http\Controllers\API\Project;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $project = Project::all();

            return response()->json([
                'message' => 'Project retrieved successfully',
                'data' => $project
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
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
                'name' => 'required|string',
            ], [
                'name.required' => 'Name is required',
                'name.string' => 'Name must be a string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ]);
            }

            $project = new Project();
            $project->name = request('name');
            $project->save();

            return response()->json([
                'message' => 'Project created successfully',
                'data' => $project
            ]);
        } catch (Exception $e) {
            return response()->json([
                'errors' => [
                    'message' => 'Failed to create project'
                ]
            ]);
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
            ], [
                'name.required' => 'Name is required',
                'name.string' => 'Name must be a string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ]);
            }

            $project =  Project::find($id);
            if (request('name')) $project->name = request('name');
            $project->save();

            return response()->json([
                'message' => 'Project updated successfully',
                'data' => $project
            ]);
        } catch (Exception $e) {
            return response()->json([
                'errors' => [
                    'message' => 'Failed to create project'
                ]
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $project = Project::find($id);
            $project->delete();

            return response()->json([
                'message' => "Project deleted successfullly",
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'errors' => [
                    'message' => $e->getMessage()
                ]
            ]);
        }
    }
}
