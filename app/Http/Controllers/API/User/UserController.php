<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $user = User::orderBy('name', 'asc')->get();

            return response()->json([
                'message' => 'User retrieved successfully',
                'data' => $user,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
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
                'username' => 'required|string',
                'email' => 'required|email',
                'password' => 'required',
                'role' => 'required',
            ], [
                'name.required' => 'Name is required',
                'name.string' => 'Name must be a string',
                'username.required' => 'Username is required',
                'username.string' => 'Username must be a string',
                'email.required' => 'Email is required',
                'email.email' => 'Email must be a valid email',
                'password.required' => 'Password is required',
                'role.required' => 'Role is required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ]);
            }

            $user = new User();
            $user->name = request('name');
            $user->username = request('username');
            $user->email = request('email');
            $user->role = request('role');
            $user->gender = request('gender');
            $user->password = bcrypt(request('password'));
            $user->save();

            return response()->json([
                'message' => 'User created successfully',
                'data' => $user
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 401);
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
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|required|string',
                'username' => 'sometimes|required|string|unique:users,username,' . $id,
                'email' => 'sometimes|required|email|unique:users,email,' . $id,
                'password' => 'sometimes|required',
                'role' => 'sometimes|required',
                'gender' => 'sometimes|required|in:men,women',
            ], [
                'name.required' => 'Name is required',
                'name.string' => 'Name must be a string',
                'username.required' => 'Username is required',
                'username.string' => 'Username must be a string',
                'username.unique' => 'Username has already been taken',
                'email.required' => 'Email is required',
                'email.email' => 'Email must be a valid email',
                'email.unique' => 'Email has already been taken',
                'password.required' => 'Password is required',
                'role.required' => 'Role is required',
                'gender.required' => 'Gender is required',
                'gender.in' => 'Gender must be either men or women',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = User::findOrFail($id);
            $user->name = $request->get('name', $user->name);
            $user->username = $request->get('username', $user->username);
            $user->email = $request->get('email', $user->email);
            $user->role = $request->get('role', $user->role);
            $user->gender = $request->get('gender', $user->gender);

            if ($request->filled('password')) {
                $user->password = bcrypt($request->password);
            }

            $user->save();

            return response()->json([
                'message' => 'User updated successfully',
                'data' => $user
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 401);
        }
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json([
                    'message' => 'User not found'
                ], 404);
            }

            $user->delete();

            return response()->json([
                'message' => 'User deleted successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 401);
        }
    }
}
