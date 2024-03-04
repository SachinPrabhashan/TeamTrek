<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SupportContract;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class SupportContractController extends Controller
{
    public function ScIndex(SupportContract $supportcontract)
    {
        //$this->authorize('view', $usermanagement);
        $supportcontracts= SupportContract::All();
        $users=User::where('role_id',4)->get();
        $existingNames = $users->pluck('name')->toArray();

        return view('admin.ScHandling', compact('supportcontracts','users','existingNames'));
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

    public function updateSC(Request $request, $id)
    {
        $request->validate([
            'company_name' => 'required',
            'name' => 'required',
        ]);

        $supportContract = SupportContract::findOrFail($id);

        $user = User::where('name', $request->input('company_name'))->first();

        if (!$user) {
            return response()->json(['error' => 'User not found for company name: ' . $request->input('company_name')], 404);
        }

        $supportContract->user_id = $user->id;
        $supportContract->name = $request->input('name');
        $supportContract->company_name = $request->input('company_name');
        $supportContract->save();

        return response()->json(['message' => 'Support contract updated successfully', 'support_contract' => $supportContract]);
    }


}
