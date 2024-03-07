<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SupportContractInstance;
use App\Models\SupportPayment;

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
        $validatedData = $request->validate([
            'support_contract' => 'required',
            'year' => 'required',
            'owner' => 'required',
            'dev_hours' => 'required',
            'eng_hours' => 'required',
            'dev_rate' => 'required',
            'eng_rate' => 'required',
        ]);
        // Check if a support contract instance with the same support contract ID and year exists
        $existingInstance = SupportContractInstance::where('support_contract_id', $validatedData['support_contract'])
            ->where('year', $validatedData['year'])
            ->first();

        if ($existingInstance) {
            return response()->json(['error' => 'A support contract instance for this support contract and year already exists.'], 422);
        }

        $supportContractInstance = new SupportContractInstance();
        $supportContractInstance->support_contract_id = $request->support_contract;
        $supportContractInstance->year = $request->year;
        $supportContractInstance->owner = $request->owner;
        $supportContractInstance->dev_hours = $request->dev_hours;
        $supportContractInstance->eng_hours = $request->eng_hours;

        try {
            $supportContractInstance->save();
        }
        catch (\Exception $e)
        {
            return response()->json(['message' => 'Failed to create Support Contract Instance'], 500);
        }

        $supportPayment = new SupportPayment();
        $supportPayment->support_contract_instance_id = $supportContractInstance->id;
        $supportPayment->dev_rate_per_hour = $request->dev_rate;
        $supportPayment->eng_rate_per_hour = $request->eng_rate;

        try {
            $supportPayment->save();
        }
        catch (\Exception $e)
        {
            return response()->json(['message' => 'Failed to save Support Contract Payment'], 500);
        }
        return response()->json(['message' => 'Support Contract Instance created successfully'], 200);
    }

    

    /*public function getSupportContractInstances($contractId)
    {
        try {
            $instances = SupportContractInstance::where('support_contract_id', $contractId)->get();

            $payments = SupportPayment::whereIn('support_contract_instance_id', $instances->pluck('id'))->get();

            $paymentDetails = [];
            foreach ($payments as $payment) {
                $paymentDetails[$payment->support_contract_instance_id] = [
                    'devRate' => $payment->dev_rate_per_hour,
                    'engRate' => $payment->eng_rate_per_hour,
                ];
            }
            return response()->json([
                'instances' => $instances,
                'paymentDetails' => $paymentDetails,

            ]);
        }
        catch (\Exception $e)
        {
            return response()->json(['error' => 'An error occurred while fetching support contract instances.'], 500);
        }
    }*/



}
