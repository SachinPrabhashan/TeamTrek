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
        $validatedData = $request->validate([
            'company_name' => 'required|string',
            'name' => 'required|string',
        ]);

        $user = User::where('name', $validatedData['company_name'])->first();

        if (!$user) {
            return response()->json(['error' => 'User not found for company name: ' . $validatedData['company_name']], 404);
        }

        $supportContract = new SupportContract();
        $supportContract->user_id = $user->id;
        $supportContract->company_name = $validatedData['company_name'];
        $supportContract->name = $validatedData['name'];

        $supportContract->save();

        return response()->json(['support_contract' => $supportContract], 201);
    }
}
