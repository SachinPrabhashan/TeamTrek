<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SupportContract;
use Illuminate\Support\Carbon;

class SupportContractController extends Controller
{
    public function ScIndex(SupportContract $supportcontract)
    {
        //$this->authorize('view', $usermanagement);
        $supportcontracts= SupportContract::All();
        $users=User::where('role_id',4)->get();

        return view('admin.ScHandling', compact('supportcontracts','users'));
    }

    public function addSC(Request $request)
{
    // Validate the request data
    $validatedData = $request->validate([
        'company_name' => 'required|string',
        'name' => 'required|string',
        // Add validation rules for other fields if needed
    ]);

    // Retrieve the user with the given company_name
    $user = User::where('name', $validatedData['company_name'])->first();

    if (!$user) {
        // User not found, handle error
        return response()->json(['error' => 'User not found for company name: ' . $validatedData['company_name']], 404);
    }

    // Create a new support contract
    $supportContract = new SupportContract();
    $supportContract->user_id = $user->id;
    $supportContract->company_name = $validatedData['company_name'];
    $supportContract->name = $validatedData['name'];
    // Set other fields if needed
    $supportContract->save();

    // Return the newly created support contract data
    return response()->json(['support_contract' => $supportContract], 201);
}
}
