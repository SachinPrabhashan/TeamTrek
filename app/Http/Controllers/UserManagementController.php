<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserManagement;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Carbon;

class UserManagementController extends Controller
{
//User Management-Employee Management
    public function UserManagementView(UserManagement $usermanagement)
    {
        $this->authorize('view', $usermanagement);
        $users = User::where('role_id', 3)->get();

        return view('admin.EmpManagement', compact('users'));
    }

    public function fetchEmployees(Request $request)
    {
        $users = User::where('role_id', 3)->get();
        return response()->json($users);
    }

    public function addEmp(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'dob' => 'required|date_format:Y-m-d',
            'address' => 'required|string',
            'phone' => 'required|string',
            'role_id' => 'required|numeric',
            'user_type' => 'required|string',
            'password' => 'required|string',
        ]);

        $phone = (int) $validatedData['phone'];

        // Create a new user record
        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->dob = $validatedData['dob'];
        $user->address = $validatedData['address'];
        $user->phone = $phone;
        $user->role_id = $validatedData['role_id'];
        $user->user_type = $validatedData['user_type'];
        $user->password = bcrypt($validatedData['password']);
        $user->save();

        return response()->json(['message' => 'User created successfully'], 200);
    }

    public function deleteEmp($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return response()->json(['message' => 'User deleted successfully'], 200);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }

    public function updateEmpType(Request $request, $userId) {
        try {
            $user = User::findOrFail($userId);
            $user->update($request->all());

            return response()->json($user, 200);
        } catch (\Exception $e) {

            return response()->json(['error' => 'Failed to update user type.'], 500);
        }
    }

//User Management-Admin Management
    public function AdminManagementView(UserManagement $usermanagement)
    {
        $this->authorize('view', $usermanagement);
        $admins = User::where('role_id', 2)->get();

        return view('admin.AdminManagement', compact('admins'));
    }

    public function addAdmin(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'role_id' => 'required|numeric',
            'password' => 'required|string',
        ]);

        try {

            $user = new User();
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            $user->role_id = $validatedData['role_id'];
            $user->password = bcrypt($validatedData['password']);
            $user->save();

            return response()->json(['message' => 'User created successfully'], 200);
        } catch (\Exception $e) {

            return response()->json(['message' => 'Failed to create user', 'error' => $e->getMessage()], 500);
        }
    }

    public function fetchAdmins(Request $request)
    {
        $admins = User::where('role_id', 2)->get();
        return response()->json($admins);
    }

}
