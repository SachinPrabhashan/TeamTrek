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
use App\Models\RemainingHour;
use App\Models\SupportPayment;
use App\Models\ExtraCharger;
use App\Models\ScView;
use Illuminate\Support\Facades\Auth;

class ScReportsViewController extends Controller
{
    public function ScView(ScView $scview)
    {
        //$this->authorize('view', $usermanagement);
        $tasks = Task::All();
        $scInstances=SupportContractInstance::All();
        $supportcontracts=SupportContract::All();
        $subtasks=SubTask::All();
        $remainingHours=RemainingHour::All();
        $extraChargers=ExtraCharger::All();

        return view('Support_Contract.SupportContractView', compact('tasks','scInstances','supportcontracts','subtasks','remainingHours','extraChargers'));
    }

    public function getSupportContractChartData(Request $request)
    {
        $supportContractId = $request->input('supportContractId');
        $year = $request->input('year');

        $supportContractInstance = SupportContractInstance::where('support_contract_id', $supportContractId)
            ->where('year', $year)
            ->first();

        if (!$supportContractInstance) {
            // Display SweetAlert if no support contract instance is found
            return response()->json(['error' => 'Support contract instance not found'], 404)
                ->header('Content-Type', 'application/json')
                ->header('X-Message-Type', 'error')
                ->header('X-Message', 'No support contract instance found for the selected values');
        }

        // Fetch dev_rate_per_hour and eng_rate_per_hour from SupportPayment
        $supportPayment = SupportPayment::where('support_contract_instance_id', $supportContractInstance->id)->first();
        $devRatePerHour = $supportPayment->dev_rate_per_hour ?? null;
        $engRatePerHour = $supportPayment->eng_rate_per_hour ?? null;

        $devHours = $supportContractInstance->dev_hours ?? null;
        $engHours = $supportContractInstance->eng_hours ?? null;

        $task = Task::where('support_contract_instance_id', $supportContractInstance->id)->first();

        // If task is null, set remainingHours and extraChargers to null
        $remainingHours = $extraChargers = null;

        if ($task) {
            $remainingHours = RemainingHour::where('task_id', $task->id)->latest()->first();
            $extraChargers = ExtraCharger::where('task_id', $task->id)->latest()->first();
        }

         // Calculate dev_chargers and eng_chargers
         $devChargers = ($extraChargers->charging_dev_hours ?? 0) * $devRatePerHour;
         $engChargers = ($extraChargers->charging_eng_hours ?? 0) * $engRatePerHour;

        // Prepare the chart data
        $chartData = [
            'labels' => ['Support Contract Hours', 'Remaining Hours', 'Charging Hours'],
            'datasets' => [
                [
                    'label' => 'Dev Hours',
                    'data' => [
                        $devHours,
                        optional($remainingHours)->rem_dev_hours,
                        optional($extraChargers)->charging_dev_hours
                    ],
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'borderWidth' => 1
                ],
                [
                    'label' => 'Eng Hours',
                    'data' => [
                        $engHours,
                        optional($remainingHours)->rem_eng_hours,
                        optional($extraChargers)->charging_eng_hours
                    ],
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1
                ]
            ]
        ];

        // Pass additional data to the frontend
        $additionalData = [
            'dev_rate_per_hour' => $devRatePerHour,
            'eng_rate_per_hour' => $engRatePerHour,
            'dev_chargers' => $devChargers,
            'eng_chargers' => $engChargers
        ];

        return response()->json(['chartData' => $chartData, 'additionalData' => $additionalData]);
    }

    public function ScReportsIndex(ScView $scview)
    {
        //$this->authorize('view', $usermanagement);
        $tasks = Task::All();
        $scInstances=SupportContractInstance::All();
        $supportcontracts=SupportContract::All();
        $subtasks=SubTask::All();
        $remainingHours=RemainingHour::All();
        $extraChargers=ExtraCharger::All();

        return view('Support_Contract.ScReports', compact('tasks','scInstances','supportcontracts','subtasks','remainingHours','extraChargers'));
    }

    public function getSupportContractReportData(Request $request)
    {
        $supportContractId = $request->input('supportContractId');
        $year = $request->input('year');

        $supportContractInstance = SupportContractInstance::where('support_contract_id', $supportContractId)
            ->where('year', $year)
            ->first();

        if (!$supportContractInstance) {
            // Display SweetAlert if no support contract instance is found
            return response()->json(['error' => 'Support contract instance not found'], 404)
                ->header('Content-Type', 'application/json')
                ->header('X-Message-Type', 'error')
                ->header('X-Message', 'No support contract instance found for the selected values');
        }

        $task = Task::where('support_contract_instance_id', $supportContractInstance->id)->first();

        $ongoingTasks = Task::where('support_contract_instance_id', $supportContractInstance->id)
        ->where('isCompleted', false)
        ->get();

        $completedTasks = Task::where('support_contract_instance_id', $supportContractInstance->id)
            ->where('isCompleted', true)
            ->get();

        $supportContract = SupportContract::find($supportContractInstance->support_contract_id);



        $remainingHours = $extraChargers = $taskaccess = null;

        if ($task) {
            $remainingHours = RemainingHour::where('task_id', $task->id)->latest()->first();
            $extraChargers = ExtraCharger::where('task_id', $task->id)->latest()->first();
            $taskaccess = TaskAccess::where('task_id', $task->id)->get();
        }

        // Prepare the data to be returned
        $responseData = [
            'supportContractInstance' => $supportContractInstance,
            'supportContract' => $supportContract,
            'task' => $task,
            'taskAccess' => $taskaccess,
            'remainingHours' => $remainingHours,
            'extraChargers' => $extraChargers,
            'ongoingTasks' => $ongoingTasks,
            'completedTasks' => $completedTasks,
        ];
        //\Log::info('Response Data:', $responseData);
        return response()->json($responseData);
    }

}

