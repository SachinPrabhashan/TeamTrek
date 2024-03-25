<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeePerformanceController extends Controller
{
    public function index(){

        $subtaskhistorys = DB::table('sub_tasks')->get();
        $employees = DB::table('users')->where('role_id', 3)->get();

        return view('employee.PerformanceEmployee',compact('subtaskhistorys', 'employees'));
    }
}
