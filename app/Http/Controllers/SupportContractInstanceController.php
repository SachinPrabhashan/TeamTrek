<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SupportContractInstance;
use App\Models\SupportPayment;
use App\Models\SupportContract;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\Task;
use App\Models\RemainingHour;

class SupportContractInstanceController extends Controller
{
    public function ScInstanceIndex(SupportContractInstance $supportcontractinstance)
    {
        //$this->authorize('view', $usermanagement);
        $supportcontracts = SupportContract::All();
        $supportcontractinstances = SupportContractInstance::All();
        $instances = SupportContractInstance::all();
        $users = User::All();
        $supportpayment = SupportPayment::all();

        return view('admin.ScInstance', compact('supportcontractinstances', 'users', 'supportcontracts', 'instances', 'supportpayment'));
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
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create Support Contract Instance'], 500);
        }

        $supportPayment = new SupportPayment();
        $supportPayment->support_contract_instance_id = $supportContractInstance->id;
        $supportPayment->dev_rate_per_hour = $request->dev_rate;
        $supportPayment->eng_rate_per_hour = $request->eng_rate;
        $supportPayment->year = $supportContractInstance->year;

        try {
            $supportPayment->save();
        } catch (\Exception $e) {
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
    public function getSupportContractInstanceData($supportContractId)
    {
        // Fetch support contract instances based on the support contract ID
        $supportContractInstances = SupportContractInstance::where('support_contract_id', $supportContractId)->get();

        // Initialize arrays to store support contract instances separately
        $devHoursArray = [];
        $engHoursArray = [];
        $instancesArray = [];

        // Iterate through each support contract instance
        foreach ($supportContractInstances as $instance) {
            // Store dev_hours, eng_hours, and year in separate arrays
            $devHoursArray[] = $instance->dev_hours;
            $engHoursArray[] = $instance->eng_hours;

            // Fetch the latest task associated with the current support contract instance
            $latestTask = Task::where('support_contract_instance_id', $instance->id)
                ->latest('updated_at') // Order tasks by updated_at field in descending order
                ->first(); // Retrieve only the latest task

            if ($latestTask) {
                // Fetch the latest remaining hours for the current task
                $latestRemainingHours = RemainingHour::where('task_id', $latestTask->id)
                    ->latest('updated_at')
                    ->first();

                // Calculate total remaining hours
                $totalRemDevHours = $latestRemainingHours->rem_dev_hours ?? 0;
                $totalRemEngHours = $latestRemainingHours->rem_eng_hours ?? 0;
            } else {
                // If no tasks found, initialize total remaining hours as 0
                $totalRemDevHours = 0;
                $totalRemEngHours = 0;
            }


            // Store the instance, along with year, total remaining dev hours, and total remaining eng hours
            $instancesArray[] = [
                'instance' => $instance,
                'year' => $instance->year,
                'total_rem_dev_hours' => $totalRemDevHours,
                'total_rem_eng_hours' => $totalRemEngHours,
            ];
        }

        // Log the data before returning as JSON response
        Log::info('Support contract instance data fetched:', [
            'dev_hours' => $devHoursArray,
            'eng_hours' => $engHoursArray,
            'instances' => $instancesArray,
        ]);

        // Return arrays containing dev_hours, eng_hours, instances, and tasks as JSON response
        return response()->json([
            'dev_hours' => $devHoursArray,
            'eng_hours' => $engHoursArray,
            'instances' => $instancesArray,
        ]);
    }

    public function editinstance(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'devhour' => 'required',
            'enghour' => 'required',
            'devhourcharge' => 'required',
            'enghourcharge' => 'required',
        ]);

        $instance = new SupportContractInstance();
        $supportPayment = new SupportPayment();

        // Assign values to the dev_hours and eng_hours properties based on validated data
        $instance->dev_hours = $validatedData['devhour'];
        $instance->eng_hours = $validatedData['enghour'];

        // Set values for dev_rate_per_hour and eng_rate_per_hour properties of the supportPayment object
        $supportPayment->dev_rate_per_hour = $validatedData['devhourcharge'];
        $supportPayment->eng_rate_per_hour = $validatedData['enghourcharge'];

        dd($instance);
        $instance->save();
        $supportPayment->save();

        return response()->json(['message' => 'Record created successfully'], 200);
    }
}
