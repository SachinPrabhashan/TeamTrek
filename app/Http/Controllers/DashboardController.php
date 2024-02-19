<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Log;


class DashboardController extends Controller
{
    public function show(Dashboard $dashboard)
    {
        // Authorize the user to view the dashboard
        $this->authorize('view', $dashboard);

        // If authorization checks pass, return the Blade view
        return view('dashboard');
    }

    /*public function show(Dashboard $dashboard)
    {
        $userRoleId = auth()->user()->role_id;
        $permissionName = 'Dashboard-View';

        //Log::info('User Role ID: ' . $userRoleId); // Log user's role ID

        // Check if the user has the required permission
        //if (!auth()->user()->can($permissionName)) {
            //Log::info('User does not have direct permission'); // Log permission check result
            //throw new AuthorizationException('You are not authorized to view this dashboard.');
        //}

        // Verify if the user's role ID matches with the role ID stored in the module_permissions table for the specified permission
        $permissionExists = \DB::table('module_permissions')
            ->where('role_id', $userRoleId)
            ->where('name', $permissionName)
            ->exists();

        //Log::info('Permission exists: ' . ($permissionExists ? 'true' : 'false')); // Log permission existence

        if (!$permissionExists) {
            //Log::info('Permission does not exist for user role'); // Log permission check result
            throw new AuthorizationException('You are not authorized to view this dashboard.');
        }

        // If authorization checks pass, return the Blade view
        return view('dashboard');
    }*/






}
