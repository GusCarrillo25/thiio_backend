<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;

class ThiioUsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function showUsers()
    {
        try {
            $users = User::all();

            return response()->json([
                'status' => 'success',
                'users' => $users,
                'code'  => 200,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'code'  =>  500,
            ]);
        }
    }

    public function editUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|max:100',
        ]);

        try {
            $update = User::find($id);
            $update->name = $request->name;
            $update->email = $request->email;
            $update->save();

            return response()->json([
                'status' => 'Success',
                'message' => 'User updated successfully!',
                'code' => 200,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'eror',
                'message' => $e->getMessage(),
                'code'  => 500,
            ]);
        }
    }

    public function deleteUser($id)
    {
        try {
            $user = User::find($id);
            $user->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'User deleted successfully',
                'code' => 200,
            ]);

        } catch (\Exception $e) {
            
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'code' => 500,
            ]);

        }
    }
}
