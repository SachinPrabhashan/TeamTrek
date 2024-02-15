<?php

namespace App\Http\Controllers;
use App\Models\Module;
use App\Models\Permission;
use Illuminate\Http\Request;

class RootPermissionController extends Controller
{
    public function index4(){

        $modules = Module::all();
        $permissions = Permission::all();
        //dd($modules, $permissions);
        return view('root.modulepermission',compact('modules', 'permissions'));
    }
}
