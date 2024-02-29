<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\ModulePermission;
use Illuminate\Support\Facades\DB;
use Laravel\Ui\Presets\React;

class RootPermissionController extends Controller
{
    // index2
    public function index2()
    {

        // $permissions = DB::table('permissions')
        //     ->select('name')
        //     ->get();

        $permissions = Permission::all();


        return view('root.permissions', compact('permissions'));
    }

    public function addpermission(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $permission = new Permission();

        $permission->name = $validatedData['name'];
        $permission->save();


        return response()->json(['message' => 'Permission create successfull!']);

    }

    public function deletepermission(Request $request){
        $permissionID = $request->input('id');

        $permission = Permission::find($permissionID);

        if (!$permission) {
            return response()->json(['error' => 'Permission not found'], 404);
        }

        $permission->delete();

        return response()->json(['message' => 'Permission deleted successfully']);
    }


    public function index3()
    {
        // $modules = DB::table('modules')
        //     ->select('name')
        //     ->get();

        $modules = Module::all();

        return view('root.modules', compact('modules'));
    }

    public function addmodule(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $module = new Module();

        $module->name = $validatedData['name'];
        $module->save();

        return response()->json(['message' => 'Module create successfull!']);
    }

    public function deletemodule(Request $request)
    {
        $moduleID = $request->input('id');

        $module = Module::find($moduleID);

        if (!$module) {
            return response()->json(['error' => 'Module not found'], 404);
        }

        $module->delete();

        return response()->json(['message' => 'Module deleted successfully']);
        // return redirect('root.modules');
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
