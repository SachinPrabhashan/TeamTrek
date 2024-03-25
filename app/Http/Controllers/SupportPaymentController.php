<?php

namespace App\Http\Controllers;
use App\Models\Task;
use App\Models\User;
use App\Models\TaskAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\SupportContract;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\SupportContractInstance;
use Illuminate\Support\Facades\Session;
use App\Models\SubTask;
use App\Models\EmpRate;
use App\Models\RemainingHour;
use App\Models\SupportPayment;
use App\Models\ExtraCharger;
use App\Models\ScView;
use Illuminate\Support\Facades\Auth;

class SupportPaymentController extends Controller
{
    public function financialHealthIndex(SupportPayment $supportpayment)
    {
        //$this->authorize('view', $usermanagement);
        $tasks = Task::All();
        $scInstances=SupportContractInstance::All();
        $supportcontracts=SupportContract::All();
        $subtasks=SubTask::All();
        $remainingHours=RemainingHour::All();
        $extraChargers=ExtraCharger::All();

        return view('Support_Contract.ScFinancialHealth', compact('tasks','scInstances','supportcontracts','subtasks','remainingHours','extraChargers'));
    }

    public function getFinancialData(Request $request)
    {
        \Log::info('Financial data request received.'); // Log the request received

        $supportContractId = $request->input('supportContractId');
        $year = $request->input('year');

        \Log::info('Support Contract ID: ' . $supportContractId); // Log the support contract ID
        \Log::info('Year: ' . $year); // Log the year

        $supportContractInstance = SupportContractInstance::where('support_contract_id', $supportContractId)
            ->where('year', $year)
            ->first();

        \Log::info('Support Contract Instance: ' . $supportContractInstance); // Log the support contract instance

        if (!$supportContractInstance) {
            // Log an error if no support contract instance is found
            \Log::error('Support contract instance not found');
            return response()->json(['error' => 'Support contract instance not found'], 404);
        }

        // Find the latest ExtraChargers directly where the support_contract_instance_id matches
        $extraChargers = ExtraCharger::where('support_contract_instance_id', $supportContractInstance->id)
            ->orderBy('created_at', 'desc')
            ->first();

        \Log::info('Extra chargers: ' . $extraChargers); // Log the extra chargers

        if (!$extraChargers) {
            // Log an error if no extra chargers are found
            \Log::error('No extra chargers found for the support contract instance');
            return response()->json(['error' => 'No extra chargers found for the support contract instance'], 404);
        }

        // Fetch support payment details based on the support contract instance ID
        $supportPayment = SupportPayment::where('support_contract_instance_id', $supportContractInstance->id)
            ->first();

        \Log::info('Support payment: ' . $supportPayment); // Log the support payment details

        if (!$supportPayment) {
            // Log an error if no support payment details are found
            \Log::error('No support payment details found for the support contract instance');
            return response()->json(['error' => 'No support payment details found for the support contract instance'], 404);
        }

        // Calculate charges for developer and engineer hours
        $devChargers = $extraChargers->charging_dev_hours * $supportPayment->dev_rate_per_hour;
        $engChargers = $extraChargers->charging_eng_hours * $supportPayment->eng_rate_per_hour;

        \Log::info('Developer charges: ' . $devChargers); // Log developer charges
        \Log::info('Engineer charges: ' . $engChargers); // Log engineer charges

        // Prepare an array to store total charges for each user
        $userCharges = [];

        // Ensure $extraChargers is an object
        if (!is_object($extraChargers)) {
            \Log::error('$extraChargers is not an object.'); // Log this error
            return response()->json(['error' => '$extraChargers is not an object'], 500); // Return an error response
        }

        // Fetch hourly rate for the user from emp_rates table
        $hourlyRate = EmpRate::where('user_id', $extraChargers->user_id)->value('hourly_rate');

        // Check if hourly rate exists
        if (!$hourlyRate) {
            // Log an error if hourly rate is not found
            \Log::error('Hourly rate not found for user ' . $extraChargers->user_id);
            return response()->json(['error' => 'Hourly rate not found for user ' . $extraChargers->user_id], 404); // Return an error response
        }

        // Calculate total charges for the user
        $totalDevCharge = $extraChargers->charging_dev_hours * $hourlyRate;
        $totalEngCharge = $extraChargers->charging_eng_hours * $hourlyRate;

        // Add total charges to the array using user_id as key
        $userCharges[$extraChargers->user_id] = [
            'totalDevCharge' => $totalDevCharge,
            'totalEngCharge' => $totalEngCharge,
        ];

        // Calculate total developer and engineer charges for all users
        $totalDevCharger = $totalDevCharge;
        $totalEngCharger = $totalEngCharge;

        // Prepare the data to be returned
        $responseData = [
            'supportContractInstance' => $supportContractInstance,
            'extraChargers' => $extraChargers,
            'supportPayment' => $supportPayment,
            'devChargers' => $devChargers,
            'engChargers' => $engChargers,
            'userCharges' => $userCharges,
            'totalDevCharger' => $totalDevCharger,
            'totalEngCharger' => $totalEngCharger,
        ];

        // Return the response
        return response()->json($responseData);
    }

}
