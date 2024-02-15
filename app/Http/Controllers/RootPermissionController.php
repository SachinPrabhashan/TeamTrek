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
        // Assuming you retrieve the role ID from the database or elsewhere
        $roleId = 1; // Example value, replace it with your actual role ID retrieval logic

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
    // Retrieve data from the AJAX request
    $moduleId = $request->input('moduleId');
    $permissionId = $request->input('permissionId');
    $isChecked = $request->input('isChecked');
    $roleId = $request->input('roleId');

    // Retrieve module and permission names from the database
    $moduleName = Module::find($moduleId)->name;
    $permissionName = Permission::find($permissionId)->name;

    // Concatenate module and permission names
    $name = $moduleName . '_' . $permissionName;

    // Check if the checkbox is checked
    if ($isChecked) {
        // If checked, create or update the module permission record
        $modulePermission = ModulePermission::updateOrCreate(
            ['module_id' => $moduleId, 'permission_id' => $permissionId, 'role_id' => $roleId],
            ['name' => $name],
        );
        $modulePermission->save();
    } else {
        // If not checked, delete the module permission record if it exists
        try {
            ModulePermission::where('module_id', $moduleId)
                ->where('permission_id', $permissionId)
                ->where('role_id', $roleId)
                ->delete();

            return response()->json(['status' => 'success', 'message' => 'Module permission deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    return response()->json(['status' => 'success', 'message' => 'Module permission saved successfully']);
}



    public function getExistingPermissions(Request $request)
    {
        $roleId = $request->input('roleId');

        // Retrieve existing module permissions based on the role ID
        $existingPermissions = ModulePermission::where('role_id', $roleId)
            ->pluck('permission_id')
            ->groupBy('module_id')
            ->toArray();

        return response()->json($existingPermissions);
    }

    public function delete(Request $request)
    {
        $moduleId = $request->input('moduleId');
        $permissionId = $request->input('permissionId');
        $roleId = $request->input('roleId');

        // Delete the module permission for the specified role
        ModulePermission::where('module_id', $moduleId)
            ->where('permission_id', $permissionId)
            ->where('role_id', $roleId)
            ->delete();

        return response()->json(['message' => 'Module permission deleted successfully']);
    }




}
