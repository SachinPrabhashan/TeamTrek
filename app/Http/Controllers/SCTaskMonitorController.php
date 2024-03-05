<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SCTaskMonitorController extends Controller
{
    public function index(){
        return view('admin.SCtaskmonitor');
    }
}
