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
        //Log::info('Monthly Details:', $monthlyDetails);

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


        $supportContractInstances = SupportContractInstance::where('support_contract_id', $supportContractId)
            ->whereYear('created_at', $year)
            ->get();

        if ($supportContractInstances->isEmpty()) {

            return response()->json(['error' => 'Support contract instance not found'], 404)
                ->header('Content-Type', 'application/json')
                ->header('X-Message-Type', 'error')
                ->header('X-Message', 'No support contract instance found for the selected values');
        }

        $supportContractInstanceId = $supportContractInstances->first()->id;

        // Retrieve the first five tasks with dev_hours and eng_hours
        $tasksfirstfive = Task::where('support_contract_instance_id', $supportContractInstanceId)
            ->where('isCompleted', true)
            ->orderBy('id')
            ->take(5)
            ->get(['dev_hours', 'eng_hours', 'name']);

        $ongoingtasksfirstfive = Task::where('support_contract_instance_id', $supportContractInstanceId)
            ->where('isCompleted', false)
            ->orderBy('id')
            ->take(5)
            ->get(['dev_hours', 'eng_hours', 'name']);


        // Fetch dev_rate_per_hour and eng_rate_per_hour from SupportPayment
        $supportPayment = SupportPayment::where('support_contract_instance_id', $supportContractInstances->first()->id)->first();
        $devRatePerHour = $supportPayment->dev_rate_per_hour ?? null;
        $engRatePerHour = $supportPayment->eng_rate_per_hour ?? null;

        $devHours = $supportContractInstances->first()->dev_hours ?? null;
        $engHours = $supportContractInstances->first()->eng_hours ?? null;

        $task = Task::where('support_contract_instance_id', $supportContractInstances->first()->id)->first();

        // If task is null, set remainingHours and extraChargers to null
        $remainingHours = $extraChargers = null;

        if ($task) {
            $remainingHours = RemainingHour::where('task_id', $task->id)->latest()->first();
            $extraChargers = ExtraCharger::where('task_id', $task->id)->latest()->first();
        }

        // Calculate dev_chargers and eng_chargers
        $devSupportChargers = ($extraChargers->charging_dev_hours ?? 0) * $devRatePerHour;
        $engSupportChargers = ($extraChargers->charging_eng_hours ?? 0) * $engRatePerHour;

        $empdevChargers = ($extraChargers->charging_dev_hours ?? 0) * $devRatePerHour;
        $empengChargers = ($extraChargers->charging_eng_hours ?? 0) * $devRatePerHour;

        // Retrieve tasks associated with the support contract instance
        $tasks = Task::where('support_contract_instance_id', $supportContractInstances->first()->id)->get();

        // Initialize variables for total charges of employees who work for support hours
        $totalSupportDevChargers = 0;
        $totalSupportEngChargers = 0;

        // Iterate through each task
        foreach ($tasks as $task) {
            // Retrieve the corresponding user's rates
            $userRates = EmpRate::where('user_id', $task->user_id)->first();
            if (!$userRates) {
                continue; // Skip if user rates not found
            }

            // Calculate charges based on dev_hours or eng_hours multiplied by the respective rate
            $devChargers = ($task->dev_hours ?? 0) * ($userRates->dev_rate_per_hour ?? 0);
            $engChargers = ($task->eng_hours ?? 0) * ($userRates->eng_rate_per_hour ?? 0);

            // Aggregate charges
            $totalSupportDevChargers += $devChargers;
            $totalSupportEngChargers += $engChargers;
        }

        $newTasks = Task::where('support_contract_instance_id', $supportContractInstances->first()->id)
            ->where('isOneDay', true)
            ->get();

        // Initialize variables for total charges of employees for new tasks
        $totalNewDevChargers = 0;
        $totalNewEngChargers = 0;

        // Iterate through each new task
        foreach ($newTasks as $newTask) {
            // Retrieve the corresponding user's rates
            $userRates = EmpRate::where('user_id', $newTask->user_id)->first();
            if (!$userRates) {
                continue; // Skip if user rates not found
            }

            // Calculate charges based on dev_hours or eng_hours multiplied by the respective rate
            $newdevChargers = ($newTask->dev_hours ?? 0) * ($userRates->dev_rate_per_hour ?? 0);
            $newengChargers = ($newTask->eng_hours ?? 0) * ($userRates->eng_rate_per_hour ?? 0);

            // Aggregate charges
            $totalNewDevChargers += $newdevChargers;
            $totalNewEngChargers += $newengChargers;
        }

    $totalRevenue= $empdevChargers + $empengChargers + $totalSupportDevChargers + $totalSupportEngChargers + $totalNewDevChargers + $totalNewEngChargers;
    $totalExpense= $devSupportChargers + $engSupportChargers;



        $response = [
            'tasksfirstfive' => $tasksfirstfive,
            'ongoingtasksfirstfive' => $ongoingtasksfirstfive,
            'totalSupportDevChargers' => $totalSupportDevChargers,
            'totalSupportEngChargers' => $totalSupportEngChargers,
            'totalRevenue' => $totalRevenue,
            'totalExpense' => $totalExpense,
        ];

        return response()->json($response);
    }




}
