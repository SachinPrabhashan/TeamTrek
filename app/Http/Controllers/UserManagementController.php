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
    public function UserManagementView(UserManagement $usermanagement)
{
    $this->authorize('view', $usermanagement);
    $users = User::all();

    return view('admin.usermanagement', ['users' => $users]);
}

    public function addUser(Request $request)
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

}
