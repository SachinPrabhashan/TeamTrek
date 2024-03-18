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

    /*public function getSupportContractChartData(Request $request)
    {
        $supportContractId = $request->input('supportContractId');
        $year = $request->input('year');

        // Fetch support contract instance based on support contract ID and year
        $supportContractInstance = SupportContractInstance::where('support_contract_id', $supportContractId)
            ->where('year', $year)
            ->first();

        if (!$supportContractInstance) {
            return response()->json(['error' => 'Support contract instance not found'], 404);
        }

        // Fetch dev_hours and eng_hours from the support contract instance
        $devHours = $supportContractInstance->dev_hours;
        $engHours = $supportContractInstance->eng_hours;

        // Fetch task associated with the support contract instance
        $task = Task::where('support_contract_instance_id', $supportContractInstance->id)->first();

        if (!$task) {
            return response()->json(['error' => 'Task not found for support contract instance'], 404);
        }

        // Fetch remaining hours from the remaining_hours table based on task ID
        $remainingHours = RemainingHour::where('task_id', $task->id)->latest()->first();

        // Fetch charging hours from the extra_chargers table based on task ID
        $extraChargers = ExtraCharger::where('task_id', $task->id)->latest()->first();

        Log::info('Checking for extra chargers...');

        if (!$extraChargers) {
            // You can return an empty array or handle the absence of extra chargers as needed
            // For now, let's return an empty array for charging dev_hours and eng_hours
            $chargingDevHours = 0;
            $chargingEngHours = 0;
        } else {
            Log::info('Extra chargers found for task ID: ' . $task->id);
            // Extract charging dev_hours and eng_hours from the extra chargers
            $chargingDevHours = $extraChargers->charging_dev_hours;
            $chargingEngHours = $extraChargers->charging_eng_hours;
            Log::info('Charging Dev Hours: ' . $chargingDevHours);
            Log::info('Charging Eng Hours: ' . $chargingEngHours);

        }

        // Prepare the chart data
        $chartData = [
            'labels' => ['Dev Hours', 'Eng Hours', 'Remaining Dev Hours', 'Remaining Eng Hours', 'Charging Dev Hours', 'Charging Eng Hours'],
            'datasets' => [
                [
                    'label' => 'Support Contract Data',
                    'data' => [$devHours, $engHours, $remainingHours->rem_dev_hours, $remainingHours->rem_eng_hours, $chargingDevHours, $chargingEngHours],
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    'borderColor' => [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    'borderWidth' => 1
                ]
            ]
        ];

        return response()->json(['chartData' => $chartData]);
    }*/

    /*public function getSupportContractChartData(Request $request)
    {
        $supportContractId = $request->input('supportContractId');
        $year = $request->input('year');

        // Fetch support contract instance based on support contract ID and year
        $supportContractInstance = SupportContractInstance::where('support_contract_id', $supportContractId)
            ->where('year', $year)
            ->first();

        if (!$supportContractInstance) {
            return response()->json(['error' => 'Support contract instance not found'], 404);
        }

        // Fetch dev_hours and eng_hours from the support contract instance
        $devHours = $supportContractInstance->dev_hours;
        $engHours = $supportContractInstance->eng_hours;

        // Fetch task associated with the support contract instance
        $task = Task::where('support_contract_instance_id', $supportContractInstance->id)->first();

        if (!$task) {
            return response()->json(['error' => 'Task not found for support contract instance'], 404);
        }

        // Fetch remaining hours from the remaining_hours table based on task ID
        $remainingHours = RemainingHour::where('task_id', $task->id)->latest()->first();

        // Fetch charging hours from the extra_chargers table based on task ID
        $extraChargers = ExtraCharger::where('task_id', $task->id)->latest()->first();

        // Prepare the chart data
        $chartData = [
            'labels' => ['Support Contract Hours', 'Remaining Hours', 'Charging Hours'],
            'datasets' => [
                [
                    'label' => 'Dev Hours',
                    'data' => [$devHours, $remainingHours->rem_dev_hours, $extraChargers->charging_dev_hours],
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'borderWidth' => 1
                ],
                [
                    'label' => 'Eng Hours',
                    'data' => [$engHours, $remainingHours->rem_eng_hours, $extraChargers->charging_eng_hours],
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1
                ]
            ]
        ];

        return response()->json(['chartData' => $chartData]);
    }*/

    public function getSupportContractChartData(Request $request)
{
    $supportContractId = $request->input('supportContractId');
    $year = $request->input('year');

    // Fetch support contract instance based on support contract ID and year
    $supportContractInstance = SupportContractInstance::where('support_contract_id', $supportContractId)
        ->where('year', $year)
        ->first();

    if (!$supportContractInstance) {
        return response()->json(['error' => 'Support contract instance not found'], 404);
    }

    // Fetch dev_hours and eng_hours from the support contract instance
    $devHours = $supportContractInstance->dev_hours;
    $engHours = $supportContractInstance->eng_hours;

    // Fetch task associated with the support contract instance
    $task = Task::where('support_contract_instance_id', $supportContractInstance->id)->first();

    /*if (!$task) {
        return response()->json(['error' => 'Task not found for support contract instance'], 404);
    }*/

    // Fetch latest remaining hours from the remaining_hours table based on task ID
    $remainingHours = RemainingHour::where('task_id', $task->id)->latest()->first();

    // Fetch latest charging hours from the extra_chargers table based on task ID
    $extraChargers = ExtraCharger::where('task_id', $task->id)->latest()->first();

    // Prepare the chart data
    $chartData = [
        'labels' => ['Support Contract Hours', 'Remaining Hours', 'Charging Hours'],
        'datasets' => [
            [
                'label' => 'Dev Hours',
                'data' => [
                    $devHours ?? 0,
                    optional($remainingHours)->rem_dev_hours ?? 0,
                    optional($extraChargers)->charging_dev_hours ?? 0
                ],
                'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                'borderColor' => 'rgba(255, 99, 132, 1)',
                'borderWidth' => 1
            ],
            [
                'label' => 'Eng Hours',
                'data' => [
                    $engHours ?? 0,
                    optional($remainingHours)->rem_eng_hours ?? 0,
                    optional($extraChargers)->charging_eng_hours ?? 0
                ],
                'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                'borderColor' => 'rgba(54, 162, 235, 1)',
                'borderWidth' => 1
            ]
        ]
    ];

    return response()->json(['chartData' => $chartData]);
}



}
