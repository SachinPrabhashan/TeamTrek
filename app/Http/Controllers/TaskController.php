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
use Illuminate\Support\Facades\DB;


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

        $taskId = $request->input('taskId');

        $users = User::where('role_id', 3)->get();

        $grantedUserIds = TaskAccess::where('task_id', $taskId)->pluck('user_id')->toArray();

        foreach ($users as $user) {
            $user->isGranted = in_array($user->id, $grantedUserIds);
        }
        return response()->json($users);
    }


    public function grantAccess(Request $request)
    {
        $taskId = $request->input('task_id');
        $selectedUsers = $request->input('selected_users');

        foreach ($selectedUsers as $userId) {
            // Check if an access record already exists for this user and task
            $existingAccess = TaskAccess::where('task_id', $taskId)
                                        ->where('user_id', $userId)
                                        ->first();

            // If an access record already exists, skip creating a new one
            if ($existingAccess) {
                continue;
            }

            // If no existing access record, create a new one
            $userName = User::findOrFail($userId)->name;

            TaskAccess::create([
                'task_id' => $taskId,
                'user_id' => $userId,
                'emp_name' => $userName,
                'isGranted' => true,
            ]);
        }

        return response()->json(['message' => 'Access granted successfully']);
    }


    public function revokeAccess(Request $request)
    {
        $request->validate([
            'task_id' => 'required|integer',
            'user_id' => 'required|integer',
        ]);

        $taskId = $request->input('task_id');
        $userId = $request->input('user_id');

        try {
            TaskAccess::where('task_id', $taskId)->where('user_id', $userId)->delete();
            return response()->json(['message' => 'Access revoked successfully']);
        }
        catch (\Exception $e) {
            return response()->json(['error' => 'Failed to revoke access'], 500);
        }
    }

    public function getTaskDetailsWithEmp($taskId)
    {
        // Retrieve task details along with support contract information
        $taskDetails = Task::with('supportContractInstance.supportContract')
            ->where('id', $taskId)
            ->first();

        if (!$taskDetails) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        // Extracting necessary data
        $supportContractYear = $taskDetails->supportContractInstance->year;
        $supportContractName = $taskDetails->supportContractInstance->supportContract->name;
        $taskName = $taskDetails->name;
        $startDate = $taskDetails->start_date;
        $endDate = $taskDetails->end_date;
        $isCompleted = $taskDetails->isCompleted;
        $description = $taskDetails->Description;

        // Retrieve emp_name from task_accesses table
        $empNames = DB::table('task_accesses')
            ->where('task_id', $taskId)
            ->pluck('emp_name')
            ->toArray();

        // Log extracted data
        Log::info('Extracted data: ' . json_encode([
            'support_contract_year' => $supportContractYear,
            'support_contract_name' => $supportContractName,
            'task_name' => $taskName,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_completed' => $isCompleted,
            'description' => $description,
            'emp_names' => $empNames,
        ]));

        // Prepare the response
        $responseData = [
            'support_contract_year' => $supportContractYear,
            'support_contract_name' => $supportContractName,
            'task_name' => $taskName,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_completed' => $isCompleted,
            'description' => $description,
            'emp_names' => $empNames,
        ];

        return response()->json($responseData);
    }

}
