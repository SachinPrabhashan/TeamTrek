<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeePerformanceController extends Controller
{
    public function index()
    {


        $employees = DB::table('users')->where('role_id', 3)->get();
        $subtaskhistorys = DB::table('sub_tasks')->get();


        return view('employee.PerformanceEmployee', compact('employees', 'subtaskhistorys'));
    }

    public function subtaskhis(Request $request)
    {
        $userId = $request->input('userId');
        $subtaskhistorys = DB::table('sub_tasks')->where('user_id', $userId)->get();

        return response()->json(['subtaskhistories' => $subtaskhistorys]);
    }
}
