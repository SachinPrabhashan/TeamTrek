<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RootPermissionController extends Controller
{
    public function index4(){
        return view('root.modulepermission');
    }
}
