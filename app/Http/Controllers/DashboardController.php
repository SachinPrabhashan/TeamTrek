<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class DashboardController extends Controller
{
    /*public function show(Dashboard $dashboard)
    {
        // Authorize the user to view the dashboard
        $this->authorize('view', $dashboard);

        // If authorization checks pass, return the Blade view
        return view('dashboard');
    }*/

    public function show(Dashboard $dashboard)
    {

        $todotasks = DB::table('tasks')
        ->where('isCompleted', 0)
         ->get();
         
        return view('dashboard', compact('todotasks'));
    }


}
