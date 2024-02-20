<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserManagement;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Log;

class UserManagementController extends Controller
{
    public function show(Dashboard $dashboard)
    {
        // Authorize the user to view the dashboard
        $this->authorize('view', $dashboard);

        // If authorization checks pass, return the Blade view
        return view('dashboard');
    }

    public function UserManagementView(UserManagement $usermanagement)
    {
        $this->authorize('view',$usermanagement);
        return view('admin.usermanagement');
    }
}
