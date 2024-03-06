<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SupportContractInstance;
use App\Models\SupportContract;

class SCTaskMonitorController extends Controller
{
    public function index(){

        // $supportcontracts=SupportContract::All();
        // $supportcontractinstances= SupportContractInstance::All();
        // $users=User::All();

        // return view('admin.SCtaskmonitor',compact('supportcontractinstances','users','supportcontracts'));
        return view('admin.SCtaskmonitor');
    }
}
