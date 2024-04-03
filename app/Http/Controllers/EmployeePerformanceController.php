<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

class EmployeePerformanceController extends Controller
{
    public function index()
    {

        $employees = DB::table('users')->where('role_id', 3)->get();
        $subtaskhistorys = DB::table('sub_tasks')->get();

        // Task Service Level
        $notstart = DB::table('tasks')->where('user_id', NULL)->count();
        $processing = Task::join('task_accesses', 'tasks.id', '=', 'task_accesses.task_id')
            ->whereNotNull('task_accesses.user_id')
            ->whereNull('tasks.user_id')
            ->count();
        $completed = Task::where('isCompleted', 1)->count();

        return view('employee.PerformanceEmployee', compact('employees', 'subtaskhistorys', 'notstart', 'processing', 'completed'));
    }

    /*public function subtaskhis(Request $request)
    {
        $userId = $request->input('userId');
        $subtaskhistorys = DB::table('sub_tasks')->where('user_id', $userId)->get();

        return response()->json(['subtaskhistories' => $subtaskhistorys]);
    }*/



    public function subtaskhis(Request $request)
    {
        $userId = $request->input('userId');

        // Retrieve subtask histories where user_id matches
        $subtaskhistorys = DB::table('sub_tasks')
            ->where('user_id', $userId)
            ->get();

        // Calculate total dev_hours and eng_hours for subtasks for that particular user
        $totalDevHours = $subtaskhistorys->sum('dev_hours');
        $totalEngHours = $subtaskhistorys->sum('eng_hours');

        // Initialize variables to store sum of dev_hours and eng_hours for tasks with isOneDay true
        $totalOneDayDevHours = 0;
        $totalOneDayEngHours = 0;

        // Retrieve all tasks with isOneDay true for this user_id
        $tasksWithOneDay = DB::table('tasks')
            ->where('user_id', $userId)
            ->where('isOneDay', true)
            ->get();

        // Calculate sum of dev_hours and eng_hours for tasks with isOneDay true
        foreach ($tasksWithOneDay as $task) {
            $totalOneDayDevHours += $task->dev_hours;
            $totalOneDayEngHours += $task->eng_hours;
        }

        // Retrieve tasks with isLastDay true for the specified user_id
        $tasksWithLastDay = DB::table('tasks')
            ->where('user_id', $userId)
            ->where('isLastDay', true)
            ->get();

        // Initialize arrays to store the sum of dev_hours and eng_hours for each task
        $lastDayTaskDevHours = [];
        $lastDayTaskEngHours = [];

        // Initialize an array to store differences for each task
        $devHoursDifferences = [];
        $engHoursDifferences = [];

        // Iterate over tasks with isLastDay true
        foreach ($tasksWithLastDay as $task) {
            // Store dev_hours for the current task
            $lastDayTaskDevHours[$task->id] = $task->dev_hours;

            // Store eng_hours for the current task
            $lastDayTaskEngHours[$task->id] = $task->eng_hours;

            // Retrieve subtasks for the current task
            $subtasks = DB::table('sub_tasks')
                ->where('task_id', $task->id)
                ->get();

            // Initialize variables to store the sum of dev_hours and eng_hours for the current task
            $sumDevHours = 0;
            $sumEngHours = 0;

            // Calculate sum of dev_hours and eng_hours for subtasks of the current task
            foreach ($subtasks as $subtask) {
                $sumDevHours += $subtask->dev_hours;
                $sumEngHours += $subtask->eng_hours;
            }

            // Store the sum of dev_hours and eng_hours for the current task
            $lastDayTaskDevHours[$task->id] += $sumDevHours;
            $lastDayTaskEngHours[$task->id] += $sumEngHours;

            // Calculate the difference for the current task
            $devHoursDifference = $lastDayTaskDevHours[$task->id] - $task->dev_hours;
            $engHoursDifference = $lastDayTaskEngHours[$task->id] - $task->eng_hours;

            // Store the difference for the current task
            $devHoursDifferences[$task->id] = $devHoursDifference;
            $engHoursDifferences[$task->id] = $engHoursDifference;
        }

        // Calculate the total sum of dev_hours and eng_hours including differences
        $totalDevHoursDifference = array_sum($devHoursDifferences);
        $totalEngHoursDifference = array_sum($engHoursDifferences);

        // Calculate the total sum of dev_hours and eng_hours including differences for one-day tasks
        $EmpDevTotal = $totalDevHours + $totalOneDayDevHours + $totalDevHoursDifference;
        $EmpEngTotal = $totalEngHours + $totalOneDayEngHours + $totalEngHoursDifference;

        $response = [
            'subtaskhistories' => $subtaskhistorys,
            'total_dev_hours' => $totalDevHours,
            'total_eng_hours' => $totalEngHours,
            'total_one_day_dev_hours' => $totalOneDayDevHours,
            'total_one_day_eng_hours' => $totalOneDayEngHours,
            'last_day_task_dev_hours' => $lastDayTaskDevHours,
            'last_day_task_eng_hours' => $lastDayTaskEngHours,
            'dev_hours_differences' => $devHoursDifferences,
            'eng_hours_differences' => $engHoursDifferences,
            'total_dev_hours_difference' => $totalDevHoursDifference,
            'total_eng_hours_difference' => $totalEngHoursDifference,
            'EmpDevTotal' => $EmpDevTotal,
            'EmpEngTotal' => $EmpEngTotal,
        ];

        return response()->json($response);
    }
}
