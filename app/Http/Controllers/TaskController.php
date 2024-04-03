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
use Illuminate\Support\Facades\Auth;


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

    public function subtaskindex(Request $request){
        $id = $request->input('id');
        $name = $request->input('name');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $description = $request->input('description');

        // dd($id, $name, $start_date, $end_date, $description);

        Session::put('id', $id);
        Session::put('name', $name);
        Session::put('start_date', $start_date);
        Session::put('end_date', $end_date);
        Session::put('description', $description);


        return view('employee.scsubtask', compact('id', 'name', 'start_date', 'end_date', 'description'));
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
        catch (\Exception $e)
        {
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
        /*Log::info('Extracted data: ' . json_encode([
            'support_contract_year' => $supportContractYear,
            'support_contract_name' => $supportContractName,
            'task_name' => $taskName,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_completed' => $isCompleted,
            'description' => $description,
            'emp_names' => $empNames,
        ]));*/

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



    /*public function createSubTask(Request $request)
    {
        $validatedData = $request->validate([
            'taskName' => 'required|string|max:255',
            'taskDate' => 'required|date',
            'developerHours' => 'required|integer',
            'engineerHours' => 'required|integer',
        ]);

        $taskId = session('id');

        $subTask = new SubTask();
        $subTask->task_id = $taskId;
        $subTask->name = $validatedData['taskName'];
        $subTask->date = $validatedData['taskDate'];
        $subTask->dev_hours = $validatedData['developerHours'];
        $subTask->eng_hours = $validatedData['engineerHours'];
        $subTask->user_id = Auth::id();
        $subTask->save();

        $task = Task::findOrFail($taskId);
        $task->dev_hours += $validatedData['developerHours'];
        $task->eng_hours += $validatedData['engineerHours'];

        if ($request->has('isLastTask') && $request->input('isLastTask') == 'on') {
            $task->end_date = $validatedData['taskDate'];
            $task->isCompleted = true;
        }
        $task->save();

        // Retrieve the support_contract_instance_id associated with the task
        $supportContractInstanceId = $task->support_contract_instance_id;

        // Retrieve the SupportContractInstance model
        $supportContractInstance = SupportContractInstance::findOrFail($supportContractInstanceId);

        // Calculate remaining hours
        $totalDevHoursSpent = Task::where('support_contract_instance_id', $supportContractInstanceId)->sum('dev_hours');
        $totalEngHoursSpent = Task::where('support_contract_instance_id', $supportContractInstanceId)->sum('eng_hours');

        $remainingDevHours = $supportContractInstance->dev_hours - $totalDevHoursSpent;
        $remainingEngHours = $supportContractInstance->eng_hours - $totalEngHoursSpent;

        // Save the remaining hours in the remaining_hours table
        $remainingHours = new RemainingHour();
        $remainingHours->task_id = $taskId;
        $remainingHours->sub_task_id = $subTask->id;
        $remainingHours->rem_dev_hours = $remainingDevHours;
        $remainingHours->rem_eng_hours = $remainingEngHours;
        $remainingHours->save();

        Session::flash('success', 'SubTask created successfully!');

        return response()->json(['success' => true]);
    }*/



    public function createSubTask(Request $request)
    {
        $validatedData = $request->validate([
            'taskName' => 'required|string|max:255',
            'taskDate' => 'required|date',
            'developerHours' => 'required|integer',
            'engineerHours' => 'required|integer',
        ]);

        $taskId = session('id');

        $subTask = new SubTask();
        $subTask->task_id = $taskId;
        $subTask->name = $validatedData['taskName'];
        $subTask->date = $validatedData['taskDate'];
        $subTask->dev_hours = $validatedData['developerHours'];
        $subTask->eng_hours = $validatedData['engineerHours'];
        $subTask->user_id = Auth::id();
        $subTask->save();

        $task = Task::findOrFail($taskId);
        $task->dev_hours += $validatedData['developerHours'];
        $task->eng_hours += $validatedData['engineerHours'];

        if ($request->has('isLastTask') && $request->input('isLastTask') == 'on') {
            $task->user_id = Auth::id();
            $task->end_date = $validatedData['taskDate'];
            $task->isCompleted = true;
            $task->isLastDay = true;
        }
        $task->save();

        // Retrieve the support_contract_instance_id associated with the task
        $supportContractInstanceId = $task->support_contract_instance_id;

        // Retrieve the SupportContractInstance model
        $supportContractInstance = SupportContractInstance::findOrFail($supportContractInstanceId);

        // Calculate remaining hours
        $totalDevHoursSpent = Task::where('support_contract_instance_id', $supportContractInstanceId)->sum('dev_hours');
        $totalEngHoursSpent = Task::where('support_contract_instance_id', $supportContractInstanceId)->sum('eng_hours');

        $remainingDevHours = $supportContractInstance->dev_hours - $totalDevHoursSpent;
        $remainingEngHours = $supportContractInstance->eng_hours - $totalEngHoursSpent;

        // Check if any of the remaining hours are zero or less
        $chargingDevHours = $remainingDevHours <= 0 ? abs($remainingDevHours) : 0;
        $chargingEngHours = $remainingEngHours <= 0 ? abs($remainingEngHours) : 0;

        // Ensure remaining hours are not negative
        $remainingDevHours = max(0, $remainingDevHours);
        $remainingEngHours = max(0, $remainingEngHours);

        //Get Support Payment
        $devHourlyRate = SupportPayment::where('support_contract_instance_id', $supportContractInstanceId)->value('dev_rate_per_hour');
        $engHourlyRate = SupportPayment::where('support_contract_instance_id', $supportContractInstanceId)->value('eng_rate_per_hour');

        $devExtraChargers=$devHourlyRate*$chargingDevHours;
        $engExtraChargers=$engHourlyRate*$chargingEngHours;

        // Save the charging hours in the extra_chargers table
        $extraChargers = new ExtraCharger();
        $extraChargers->task_id = $taskId;
        $extraChargers->sub_task_id = $subTask->id;
        $extraChargers->user_id = Auth::id();
        $extraChargers->support_contract_instance_id = $supportContractInstanceId;
        $extraChargers->charging_dev_hours = $chargingDevHours;
        $extraChargers->charging_eng_hours = $chargingEngHours;
        $extraChargers->chargers_for_dev_hours = $devExtraChargers;
        $extraChargers->chargers_for_eng_hours = $engExtraChargers;
        $extraChargers->save();

        // Save the remaining hours in the remaining_hours table
        $remainingHours = new RemainingHour();
        $remainingHours->task_id = $taskId;
        $remainingHours->sub_task_id = $subTask->id;
        $remainingHours->rem_dev_hours = $remainingDevHours;
        $remainingHours->rem_eng_hours = $remainingEngHours;
        $remainingHours->save();

        Session::flash('success', 'SubTask created successfully!');

        return response()->json(['success' => true]);
    }

    public function finishTask(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'finishDate' => 'required|date',
                'developerHoursFinish' => 'required|integer',
                'engineerHoursFinish' => 'required|integer',
            ]);

            $taskId = session('id');
            $task = Task::find($taskId);

            if (!$task) {
                return response()->json(['error' => 'Task not found.'], 404);
            }

            if (empty($task->dev_hours) && empty($task->eng_hours)) {
                $task->dev_hours = $validatedData['developerHoursFinish'];
                $task->eng_hours = $validatedData['engineerHoursFinish'];
            } else {
                $task->dev_hours += $validatedData['developerHoursFinish'];
                $task->eng_hours += $validatedData['engineerHoursFinish'];
            }

            $task->end_date = $validatedData['finishDate'];
            $task->isCompleted = true;
            $task->user_id = Auth::id();
            $task->isOneDay = true;

            $task->save();

            // Retrieve the support_contract_instance_id associated with the task
        $supportContractInstanceId = $task->support_contract_instance_id;

        // Retrieve the SupportContractInstance model
        $supportContractInstance = SupportContractInstance::findOrFail($supportContractInstanceId);

        // Calculate remaining hours
        $totalDevHoursSpent = Task::where('support_contract_instance_id', $supportContractInstanceId)->sum('dev_hours');
        $totalEngHoursSpent = Task::where('support_contract_instance_id', $supportContractInstanceId)->sum('eng_hours');

        $remainingDevHours = $supportContractInstance->dev_hours - $totalDevHoursSpent;
        $remainingEngHours = $supportContractInstance->eng_hours - $totalEngHoursSpent;

        // Check if any of the remaining hours are zero or less
        $chargingDevHours = $remainingDevHours <= 0 ? abs($remainingDevHours) : 0;
        $chargingEngHours = $remainingEngHours <= 0 ? abs($remainingEngHours) : 0;

        // Ensure remaining hours are not negative
        $remainingDevHours = max(0, $remainingDevHours);
        $remainingEngHours = max(0, $remainingEngHours);

        //Get Support Payment
        $devHourlyRate = SupportPayment::where('support_contract_instance_id', $supportContractInstanceId)->value('dev_rate_per_hour');
        $engHourlyRate = SupportPayment::where('support_contract_instance_id', $supportContractInstanceId)->value('eng_rate_per_hour');


        $devExtraChargers=$devHourlyRate*$chargingDevHours;
        $engExtraChargers=$engHourlyRate*$chargingEngHours;

        // Save the charging hours in the extra_chargers table
        $extraChargers = new ExtraCharger();
        $extraChargers->task_id = $taskId;
        $extraChargers->user_id = Auth::id();
        $extraChargers->support_contract_instance_id = $supportContractInstanceId;
        $extraChargers->charging_dev_hours = $chargingDevHours;
        $extraChargers->charging_eng_hours = $chargingEngHours;
        $extraChargers->chargers_for_dev_hours = $devExtraChargers;
        $extraChargers->chargers_for_eng_hours = $engExtraChargers;
        $extraChargers->save();

        // Save the remaining hours in the remaining_hours table
        $remainingHours = new RemainingHour();
        $remainingHours->task_id = $taskId;
        //$remainingHours->sub_task_id = $subTask->id;
        $remainingHours->rem_dev_hours = $remainingDevHours;
        $remainingHours->rem_eng_hours = $remainingEngHours;
        $remainingHours->save();

        Session::flash('success', 'SubTask created successfully!');

            return response()->json(['success' => true]);
        }
        catch (\Exception $e)
        {
            return response()->json(['error' => 'An error occurred. Please try again.'], 500);
        }
    }


}
