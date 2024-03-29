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
        $supportContractId = $request->input('supportContractId');
        $year = $request->input('year');

        // Prepare an array to store monthly details
        $monthlyDetails = [];

        // Retrieve data for the specified year and support contract
        $supportContractInstances = SupportContractInstance::where('support_contract_id', $supportContractId)
            ->whereYear('created_at', $year)
            ->get();

        // Loop through each support contract instance
        foreach ($supportContractInstances as $instance) {
            // Extract the month from the created_at timestamp
            $month = $instance->created_at->format('m');

            // Find the latest ExtraChargers directly where the support_contract_instance_id matches
            $extraChargers = ExtraCharger::where('support_contract_instance_id', $instance->id)
                ->orderBy('created_at', 'desc')
                ->first();

            if (!$extraChargers) {
                // If no extra chargers found for the support contract instance, skip to the next instance
                continue;
            }

            // Fetch support payment details based on the support contract instance ID
            $supportPayment = SupportPayment::where('support_contract_instance_id', $instance->id)
                ->first();

            if (!$supportPayment) {
                // If no support payment details found for the support contract instance, skip to the next instance
                continue;
            }

            // Calculate charges for developer and engineer hours
            $devChargers = $extraChargers->charging_dev_hours * $supportPayment->dev_rate_per_hour;
            $engChargers = $extraChargers->charging_eng_hours * $supportPayment->eng_rate_per_hour;

            // Fetch hourly rate for the user from emp_rates table
            $hourlyRate = EmpRate::where('user_id', $extraChargers->user_id)->value('hourly_rate');

            if (!$hourlyRate) {
                // If hourly rate not found for the user, skip to the next instance
                continue;
            }

            // Calculate total charges for the user
            $totalDevCharge = $extraChargers->charging_dev_hours * $hourlyRate;
            $totalEngCharge = $extraChargers->charging_eng_hours * $hourlyRate;

            // Add monthly details to the array
            $monthlyDetails[$month] = [
                'supportContractInstance' => $instance,
                'extraChargers' => $extraChargers,
                'supportPayment' => $supportPayment,
                'devChargers' => $devChargers,
                'engChargers' => $engChargers,
                'totalDevCharger' => $totalDevCharge,
                'totalEngCharger' => $totalEngCharge,
            ];
        }

        // Return the response with monthly details
        return response()->json($monthlyDetails);
    }

    public function ScAnalysisIndex(SupportPayment $supportpayment)
    {
        //$this->authorize('view', $usermanagement);
        $tasks = Task::All();
        $scInstances=SupportContractInstance::All();
        $supportcontracts=SupportContract::All();
        $subtasks=SubTask::All();
        $remainingHours=RemainingHour::All();
        $extraChargers=ExtraCharger::All();

        return view('Support_Contract.ScAnalysisView', compact('tasks','scInstances','supportcontracts','subtasks','remainingHours','extraChargers'));
    }

    public function getScAnalysisView(Request $request)
    {
        $supportContractId = $request->input('supportContractId');
        $year = $request->input('year');

        // Prepare an array to store monthly details
        $monthlyDetails = [];

        // Retrieve data for the specified year and support contract
        $supportContractInstances = SupportContractInstance::where('support_contract_id', $supportContractId)
            ->whereYear('created_at', $year)
            ->get();

        // Loop through each support contract instance
        foreach ($supportContractInstances as $instance) {
            // Extract the month from the created_at timestamp
            $month = $instance->created_at->format('m');

            // Find the latest ExtraChargers directly where the support_contract_instance_id matches
            $extraChargers = ExtraCharger::where('support_contract_instance_id', $instance->id)
                ->orderBy('created_at', 'desc')
                ->first();
                
            if (!$extraChargers) {
                // If no extra chargers found for the support contract instance, skip to the next instance
                continue;
            }
            // Fetch support payment details based on the support contract instance ID
            $supportPayment = SupportPayment::where('support_contract_instance_id', $instance->id)
                ->first();

            if (!$supportPayment) {
                // If no support payment details found for the support contract instance, skip to the next instance
                continue;
            }

            // Calculate charges for developer and engineer hours
            $devChargers = $extraChargers->charging_dev_hours * $supportPayment->dev_rate_per_hour;
            $engChargers = $extraChargers->charging_eng_hours * $supportPayment->eng_rate_per_hour;

            // Fetch hourly rate for the user from emp_rates table
            $hourlyRate = EmpRate::where('user_id', $extraChargers->user_id)->value('hourly_rate');

            if (!$hourlyRate) {
                // If hourly rate not found for the user, skip to the next instance
                continue;
            }

            // Calculate total charges for the user
            $totalDevCharge = $extraChargers->charging_dev_hours * $hourlyRate;
            $totalEngCharge = $extraChargers->charging_eng_hours * $hourlyRate;

            // Add monthly details to the array
            $monthlyDetails[$month] = [
                'supportContractInstance' => $instance,
                'extraChargers' => $extraChargers,
                'supportPayment' => $supportPayment,
                'devChargers' => $devChargers,
                'engChargers' => $engChargers,
                'totalDevCharger' => $totalDevCharge,
                'totalEngCharger' => $totalEngCharge,
            ];
        }

        // Return the response with monthly details
        return response()->json($monthlyDetails);
    }

}
