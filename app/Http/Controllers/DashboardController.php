<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Dashboard;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Access\AuthorizationException;


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

         $individualTasks = DB::table('task_accesses')
         ->select('user_id', DB::raw('count(*) as task_count'))
         ->where('user_id', 5) // Replace $userId with the actual user ID you want to filter by
         ->groupBy('user_id')
         ->get()
         ->toArray();

        $teams = DB::table('users')
        ->where('role_id', 3)
        ->get();


        return view('dashboard', compact('todotasks', 'individualTasks', 'teams'));
    }


}
