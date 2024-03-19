<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeePerformanceController extends Controller
{
    public function index(){

        return view('employee.PerformanceEmployee');
    }
}
