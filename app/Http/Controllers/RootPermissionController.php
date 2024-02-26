<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\ModulePermission;
use Illuminate\Support\Facades\DB;

class RootPermissionController extends Controller
{

    public function index2()
    {

        $permissions = DB::table('permissions')
            ->select('name')
            ->get();

        return view('root.permissions', compact('permissions'));
    }

    public function index4()
    {
        $roleId = 1;

        $modules = Module::all();
        $permissions = Permission::all();

        // Fetch existing module permissions based on the role ID
        $existingModulePermissions = ModulePermission::where('role_id', $roleId)
            ->select('module_id', 'permission_id')
            ->get()
            ->groupBy('module_id')
            ->map(function ($item) {
                return $item->pluck('permission_id')->toArray();
            });

        return view('root.modulepermission', compact('modules', 'permissions', 'existingModulePermissions', 'roleId'));
    }

    public function save(Request $request)
    {
        $moduleId = $request->input('moduleId');
        $permissionId = $request->input('permissionId');
        $isChecked = $request->input('isChecked');
        $roleId = $request->input('roleId');

        $moduleName = Module::find($moduleId)->name;
        $permissionName = Permission::find($permissionId)->name;

        $name = $moduleName . '-' . $permissionName;

        if ($isChecked) {
            $modulePermission = ModulePermission::create([
                'module_id' => $moduleId,
                'permission_id' => $permissionId,
                'role_id' => $roleId,
                'name' => $name,
            ]);
        }

        return response()->json(['status' => 'success', 'message' => 'Module permission saved successfully']);
    }


    public function getExistingPermissions(Request $request)
    {
        $roleId = $request->input('roleId');

        // Retrieve existing module permissions based on the role ID
        $existingPermissions = ModulePermission::where('role_id', $roleId)
            ->select('module_id', 'permission_id')
            ->get()
            ->groupBy('module_id')
            ->map(function ($permissions) {
                return $permissions->pluck('permission_id')->toArray();
            });

        return response()->json($existingPermissions);
    }


    public function delete(Request $request)
    {
        $moduleId = $request->input('moduleId');
        $permissionId = $request->input('permissionId');
        $roleId = $request->input('roleId');

        ModulePermission::where('module_id', $moduleId)
            ->where('permission_id', $permissionId)
            ->where('role_id', $roleId)
            ->delete();

        return response()->json(['message' => 'Module permission deleted successfully']);
    }
}
