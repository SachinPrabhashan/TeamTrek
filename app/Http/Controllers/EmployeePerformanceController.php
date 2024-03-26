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


        return view('employee.PerformanceEmployee', compact('employees', 'subtaskhistorys'));
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

        // Calculate total dev_hours and eng_hours for all the subtasks
        $totalSubTaskDevHours = Task::sum('dev_hours');
        $totalSubTaskEngHours = Task::sum('eng_hours');

        // Retrieve dev_hours and eng_hours where isOneday is true in the tasks table
        $taskOnedayDevHours = DB::table('tasks')
                                ->where('user_id', $userId)
                                ->where('isOneday', true)
                                ->sum('dev_hours');

        $taskOnedayEngHours = DB::table('tasks')
                                ->where('user_id', $userId)
                                ->where('isOneday', true)
                                ->sum('eng_hours');

        // Retrieve dev_hours and eng_hours where isLastDay is true in the tasks table
        $taskLastDayDevHours = DB::table('tasks')
                                ->where('user_id', $userId)
                                ->where('isLastDay', true)
                                ->sum('dev_hours');

        $taskLastDayEngHours = DB::table('tasks')
                                ->where('user_id', $userId)
                                ->where('isLastDay', true)
                                ->sum('eng_hours');

        // Calculate the differences
        $devHoursDifference = abs($totalDevHours - $taskLastDayDevHours);
        $engHoursDifference = abs($totalEngHours - $taskLastDayEngHours);


        // Calculate EmpDevTotal and EmpEngTotal
        $EmpDevTotal = $totalDevHours + $taskOnedayDevHours + $devHoursDifference;
        $EmpEngTotal = $totalEngHours + $taskOnedayEngHours + $engHoursDifference;

        // Prepare the response
        $response = [
            'subtaskhistories' => $subtaskhistorys,
            'total_dev_hours' => $totalDevHours,
            'total_eng_hours' => $totalEngHours,
            'task_oneday_dev_hours' => $taskOnedayDevHours,
            'task_oneday_eng_hours' => $taskOnedayEngHours,
            'task_last_day_dev_hours' => $taskLastDayDevHours,
            'task_last_day_eng_hours' => $taskLastDayEngHours,
            'dev_hours_difference' => $devHoursDifference,
            'eng_hours_difference' => $engHoursDifference,
            'EmpDevTotal' => $EmpDevTotal,
            'EmpEngTotal' => $EmpEngTotal,
        ];

        // Return the response as JSON
        return response()->json($response);
    }



}
