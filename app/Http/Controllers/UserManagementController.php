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
        $this->authorize('view',$usermanagement);
        return view('admin.usermanagement');
    }

    public function addUser(Request $request)
{
    // Log request data for debugging
    \Log::info('Request data:', $request->all());

    // Validate the form data
    $validatedData = $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users',
        'dob' => 'required|date_format:Y-m-d', // Specify the date format
        'address' => 'required|string',
        'phone' => 'required|string',
        'role_id' => 'required|numeric',
        'user_type' => 'required|string',
        'password' => 'required|string',
    ]);

    // Convert the date format before saving to the database
    //$dob = Carbon::createFromFormat('d-m-Y', $validatedData['dob'])->format('Y-m-d');

    // Cast phone to integer
    $phone = (int) $validatedData['phone'];

    // Create a new user record
    $user = new User();
    $user->name = $validatedData['name'];
    $user->email = $validatedData['email'];
    $user->dob = $validatedData['dob']; // Use the converted date
    $user->address = $validatedData['address'];
    $user->phone = $phone; // Use the converted phone
    $user->role_id = $validatedData['role_id'];
    $user->user_type = $validatedData['user_type'];
    $user->password = bcrypt($validatedData['password']);
    $user->save();

    // Return a response
    return response()->json(['message' => 'User created successfully'], 200);
}

}
