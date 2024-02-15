<?php

namespace App\Http\Controllers;
use App\Models\Module;
use App\Models\Permission;
use App\Models\ModulePermission;
use Illuminate\Http\Request;

class RootPermissionController extends Controller
{
    public function index4()
    {
        $modules = Module::all();
        $permissions = Permission::all();

        // Fetch existing module permissions
        $existingModulePermissions = ModulePermission::select('module_id', 'permission_id')
            ->get()
            ->groupBy('module_id')
            ->map(function ($item) {
                return $item->pluck('permission_id')->toArray();
            });

        return view('root.modulepermission', compact('modules', 'permissions', 'existingModulePermissions'));
    }

    public function save(Request $request)
    {
        // Retrieve data from the AJAX request
        $moduleId = $request->input('moduleId');
        $permissionId = $request->input('permissionId');
        $isChecked = $request->input('isChecked');

        // Retrieve module and permission names from the database
        $moduleName = Module::find($moduleId)->name;
        $permissionName = Permission::find($permissionId)->name;

        // Concatenate module and permission names
        $name = $moduleName . '_' . $permissionName;

        // Check if the checkbox is checked
        if ($isChecked) {
            // If checked, create or update the module permission record
            $modulePermission = ModulePermission::updateOrCreate(
                ['module_id' => $moduleId, 'permission_id' => $permissionId],
                ['name' => $name]
            );
            $modulePermission->save();
        }
        else {
            // If not checked, delete the module permission record if it exists
            try {
                ModulePermission::where('module_id', $moduleId)
                    ->where('permission_id', $permissionId)
                    ->delete();

                return response()->json(['status' => 'success', 'message' => 'Module permission deleted successfully']);
            }
            catch (\Exception $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }

        return response()->json(['status' => 'success', 'message' => 'Module permission saved successfully']);
    }


    public function getExistingModulePermissions()
    {
        // Retrieve existing module permissions from the database
        $existingPermissions = ModulePermission::select('module_id', 'permission_id')->get()->groupBy('module_id')->map(function ($permissions) {
            return $permissions->pluck('permission_id')->toArray();
        })->toArray();

        // Return the existing module permissions as JSON response
        return response()->json($existingPermissions);
    }
    
    public function delete(Request $request)
    {
        $moduleId = $request->input('moduleId');
        $permissionId = $request->input('permissionId');

        // Find and delete the module permission record
        ModulePermission::where('module_id', $moduleId)
            ->where('permission_id', $permissionId)
            ->delete();

        // Return a response indicating success
        return response()->json(['status' => 'success', 'message' => 'Module permission deleted successfully']);
    }


}
