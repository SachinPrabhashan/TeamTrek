<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\SupportContractInstance;
use App\Models\Task;
use App\Models\SupportContract;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function TaskIndex(Task $task)
    {
        //$this->authorize('view', $usermanagement);
        $users = Task::All();
        $scInstances=SupportContractInstance::All();
        $supportcontracts=SupportContract::All();

        return view('admin.SCtaskmonitor', compact('users','scInstances','supportcontracts'));
    }

    public function addTask(Request $request)
{
    try {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'taskName' => 'required|string',
            'taskDescription' => 'required|string',
            'startDate' => 'required|date',
            //'endDate' => 'required|date',
            'supportContractId' => 'required|integer',
            'supportContractInstance' => 'required|integer'
        ]);

        // Log validated data for debugging
        Log::info('Validated data: ' . json_encode($validatedData));

        // Create a new task instance
        $task = new Task();
        $task->name = $validatedData['taskName'];
        $task->description = $validatedData['taskDescription'];
        $task->start_date = $validatedData['startDate'];
        //$task->end_date = $validatedData['endDate'];

        // Fetch the support_contract_instance_id based on supportContractId and supportContractInstance
        $supportContractInstanceId = SupportContractInstance::where('support_contract_id', $validatedData['supportContractId'])
            ->where('year', $validatedData['supportContractInstance'])
            ->value('id');

        // Log support contract instance ID for debugging
        Log::info('Support contract instance ID: ' . $supportContractInstanceId);

        // Check if support_contract_instance_id was found
        if (!$supportContractInstanceId) {
            // Return a response indicating failure
            return response()->json(['error' => 'Support contract instance not found'], 404);
        }

        // Assign the support_contract_instance_id to the task
        $task->support_contract_instance_id = $supportContractInstanceId;

        // Save the task to the database
        $task->save();

        // Return a response indicating success
        return response()->json(['message' => 'Task created successfully'], 201);
    } catch (\Exception $e) {
        // Log the exception for debugging
        Log::error('Error: ' . $e->getMessage());

        // Handle the error gracefully, e.g., return a JSON response with an error message
        return response()->json(['error' => 'An error occurred'], 500);
    }
}
}
