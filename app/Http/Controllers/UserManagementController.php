<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserManagement;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\EmpRate;
use Illuminate\Support\Carbon;

class UserManagementController extends Controller
{
//User Management-Employee Management---------------------------------
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
        try {
            $validatedData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'dob' => 'required|date_format:Y-m-d',
                'address' => 'required|string',
                'phone' => 'required|string',
                'role_id' => 'required|numeric',
                'user_type' => 'required|string',
                'password' => 'required|string',
                'hourly_charge' => 'required|numeric',
                'year' => 'required|integer',
            ]);

            $phone = (int) $validatedData['phone'];

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

            $empRate = new EmpRate();
            $empRate->hourly_rate = $validatedData['hourly_charge'];
            $empRate->year = $validatedData['year'];
            $empRate->user_id = $user->id;
            $empRate->save();

            return response()->json(['message' => 'User created successfully'], 200);
        }
        catch (\Exception $e)
        {

            \Log::error('Error creating user: ' . $e->getMessage());

            return response()->json(['error' => 'Failed to create user.'], 500);
        }
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

            $user->update([
                'user_type' => $request->input('user_type')
            ]);

            $empRate = EmpRate::where('user_id', $userId)->firstOrFail();
            $empRate->update([
                'hourly_rate' => $request->input('hourly_rate')
            ]);
            return response()->json($user, 200);
        }
        catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update user type and hourly rate.'], 500);
        }
    }

    public function getEmpRates($userId) {
        try {
            $user = User::findOrFail($userId);
            $empRate = EmpRate::where('user_id', $userId)->first();

            if (!$empRate) {
                return response()->json(['error' => 'Hourly rate not found for this user.'], 404);
            }

            $userData = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'user_type'=>$user->user_type,

                'hourly_rate' => $empRate->hourly_rate,
            ];

            return response()->json($userData, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch user details.'], 500);
        }
    }





//User Management-Admin Management--------------------------------------
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

    public function deleteAdmin($id)
    {
        $admin = User::find($id);
        if ($admin) {
            $admin->delete();
            return response()->json(['message' => 'User deleted successfully'], 200);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }

    public function getAdmins($id)
    {
        $admin = User::find($id);
        return response()->json($admin);
    }

    public function updateAdmin(Request $request, $id)
    {
        $admin = User::find($id);
        $admin->name = $request->input('name');
        $admin->email = $request->input('email');

        $password = $request->input('password');
        if (!empty($password)) {
            $admin->password = bcrypt($password);
        }

        $admin->save();
        return response()->json(['message' => 'User details updated successfully']);
    }


//User Management-Client Management----------------------------------------
    public function ClientManagementView(UserManagement $usermanagement)
    {
        $this->authorize('view', $usermanagement);
        $clients = User::where('role_id', 4)->get();

        return view('admin.ClientManagement', compact('clients'));
    }

    public function addClient(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'address' => 'required|string',
            'phone' => 'required|string',
            'role_id' => 'required|numeric',
            'password' => 'required|string',
        ]);

        $phone = (int) $validatedData['phone'];

        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->address = $validatedData['address'];
        $user->phone = $phone;
        $user->role_id = $validatedData['role_id'];
        $user->password = bcrypt($validatedData['password']);
        $user->save();

        return response()->json(['message' => 'User created successfully'], 200);
    }

    public function fetchClients(Request $request)
    {
        $clients = User::where('role_id', 4)->get();
        return response()->json($clients);
    }

    public function deleteClient($id)
    {
        $client = User::find($id);
        if ($client) {
            $client->delete();
            return response()->json(['message' => 'User deleted successfully'], 200);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }
    public function getClients($id)
    {
        $client = User::find($id);
        return response()->json($client);
    }


    public function updateClient(Request $request, $id)
    {
        $client = User::find($id);
        $client->name = $request->input('name');
        $client->email = $request->input('email');
        $client->address = $request->input('address');
        $client->phone = $request->input('phone');
        $client->save();
        return response()->json(['message' => 'User details updated successfully']);
    }
}
