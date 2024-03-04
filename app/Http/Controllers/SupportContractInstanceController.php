<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SupportContractInstance;
use App\Models\SupportContract;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class SupportContractInstanceController extends Controller
{
    public function ScInstanceIndex(SupportContractInstance $supportcontractinstance)
    {
        //$this->authorize('view', $usermanagement);
        $supportcontracts=SupportContract::All();
        $supportcontractinstances= SupportContractInstance::All();
        $users=User::All();

        return view('admin.ScInstance', compact('supportcontractinstances','users','supportcontracts'));
    }

    public function addScInstances(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'support_contract' => 'required', // Add validation rules for other fields as needed
            // Add validation rules for other fields as needed
        ]);

        // Create a new SupportContractInstance instance
        $supportContractInstance = new SupportContractInstance();
        $supportContractInstance->support_contract_id = $request->support_contract;
        $supportContractInstance->year = $request->year;
        $supportContractInstance->owner_id = $request->owner;
        $supportContractInstance->dev_hours = $request->dev_hours;
        $supportContractInstance->eng_hours = $request->eng_hours;
        $supportContractInstance->dev_rate = $request->dev_rate;
        $supportContractInstance->eng_rate = $request->eng_rate;

        // Save the SupportContractInstance
        $supportContractInstance->save();

        // Optionally, you can return a response
        return response()->json(['message' => 'Support Contract Instance created successfully'], 200);
    }
}
