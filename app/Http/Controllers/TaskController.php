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
        $tasks = Task::All();
        $scInstances=SupportContractInstance::All();
        $supportcontracts=SupportContract::All();

        return view('admin.SCtaskmonitor', compact('tasks','scInstances','supportcontracts'));
    }

    public function addTask(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'taskName' => 'required|string',
                'taskDescription' => 'required|string',
                'startDate' => 'required|date',
                //'endDate' => 'required|date',
                'supportContractId' => 'required|integer',
                'supportContractInstance' => 'required|integer'
            ]);

            $task = new Task();
            $task->name = $validatedData['taskName'];
            $task->description = $validatedData['taskDescription'];
            $task->start_date = $validatedData['startDate'];
            //$task->end_date = $validatedData['endDate'];

            $supportContractInstanceId = SupportContractInstance::where('support_contract_id', $validatedData['supportContractId'])
                ->where('year', $validatedData['supportContractInstance'])
                ->value('id');

            // Check if support_contract_instance_id was found
            if (!$supportContractInstanceId) {
                return response()->json(['error' => 'Support contract instance not found'], 404);
            }

            $task->support_contract_instance_id = $supportContractInstanceId;

            $task->save();


            return response()->json(['message' => 'Task created successfully'], 201);
        }
        catch (\Exception $e)
        {

            return response()->json(['error' => 'An error occurred'], 500);
        }
    }

    public function fetchTasks(Request $request)
    {
        try {
            // Validate request data
            $validatedData = $request->validate([
                'supportContractId' => 'required|integer',
                'supportContractYear' => 'required|integer',
            ]);

            // Fetch the support contract instance ID
            $supportContractInstanceId = SupportContractInstance::where('support_contract_id', $validatedData['supportContractId'])
                ->where('year', $validatedData['supportContractYear'])
                ->value('id');

            // Check if support contract instance ID is found
            if (!$supportContractInstanceId) {
                throw new \Exception('Support contract instance not found.');
            }

            // Fetch tasks based on the support contract instance ID
            $tasks = Task::where('support_contract_instance_id', $supportContractInstanceId)->get();

            // Return tasks as JSON response
            return response()->json($tasks);
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Error fetching tasks:', ['error' => $e->getMessage()]);

            // Return an error response
            return response()->json(['error' => 'An error occurred while fetching tasks.'], 500);
        }
    }

}
