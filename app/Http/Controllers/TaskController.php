<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\SupportContractInstance;
use App\Models\Task;
use App\Models\SupportContract;
use App\Models\TaskAccess;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function TaskIndex(Task $task)
    {
        //$this->authorize('view', $usermanagement);
        $tasks = Task::where('isCompleted', 0)->get();
        $scInstances=SupportContractInstance::All();
        $supportcontracts=SupportContract::All();

        return view('admin.SCtaskmonitor', compact('tasks','scInstances','supportcontracts'));
    }

    public function AllTaskIndex(Task $task)
    {
        //$this->authorize('view', $usermanagement);
        $tasks = Task::where('isCompleted', 1)->get();
        $scInstances=SupportContractInstance::All();
        $supportcontracts=SupportContract::All();

        return view('admin.allTasks', compact('tasks','scInstances','supportcontracts'));
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
            $validatedData = $request->validate([
                'supportContractId' => 'required|integer',
                'year' => 'required|integer',
            ]);

            $supportContractInstanceId = SupportContractInstance::where('support_contract_id', $validatedData['supportContractId'])
                ->where('year', $validatedData['year'])
                ->value('id');

            if (!$supportContractInstanceId) {
                throw new \Exception('Support contract instance not found.');
            }

            $tasks = Task::where('support_contract_instance_id', $supportContractInstanceId)
            ->where('isCompleted', 0)
            ->get();

            return response()->json($tasks);
        }
        catch (\Exception $e)
        {
            return response()->json(['error' => 'An error occurred while fetching tasks.'], 500);
        }
    }

    public function deleteTask($id)
    {
        $task =Task::find($id);
        if ($task) {
            $task->delete();
            return response()->json(['message' => 'Task deleted successfully'], 200);
        } else {
            return response()->json(['error' => 'Task not found'], 404);
        }
    }
    public function getUEmpForTasks(Request $request)
    {

        $users = User::where('role_id', 3)->get();

        return response()->json($users);
    }
    
    public function grantAccess(Request $request)
    {
        Log::info('Grant access request received.');

        $taskId = $request->input('task_id');
        $selectedUsers = $request->input('selected_users');

        Log::info('Task ID: ' . $taskId);
        Log::info('Selected Users: ' . json_encode($selectedUsers));

        $userNames = User::whereIn('id', $selectedUsers)->pluck('name', 'id');

        foreach ($selectedUsers as $userId) {
        TaskAccess::create([
            'task_id' => $taskId,
            'emp_name' => $userNames[$userId] // Use the fetched name corresponding to the user ID
        ]);
    }

        return response()->json(['message' => 'Access granted successfully']);
    }



}
