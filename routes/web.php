<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\SupportContractInstance;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleViewController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeePerformanceController;
use App\Http\Controllers\RootPermissionController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\SupportContractController;
use App\Http\Controllers\SupportContractInstanceController;
use App\Http\Controllers\ScReportsViewController;
use App\Http\Controllers\SupportPaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/reg', function () {
    return view('auth.register');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// root----------------------------------------------------------------------------------------------------------------------
Route::get('/permissions/module-permission', [RootPermissionController::class, 'index4'])->name('root.modulepermission');
Route::post('/save-module-permission', [RootPermissionController::class, 'save']);
Route::get('/permissions/manage-permissions', [RootPermissionController::class, 'index2'])->name('root.permissions');
Route::post('/save-permission', [RootPermissionController::class, 'addpermission']);
Route::post('/delete-permission', [RootPermissionController::class, 'deletepermission']);

Route::get('/permissions/manage-modules', [RootPermissionController::class, 'index3'])->name('root.modules');
Route::post('/save-module', [RootPermissionController::class, 'addmodule']);
Route::post('/delete-module', [RootPermissionController::class, 'deletemodule']);




Route::post('/delete-module-permission', [RootPermissionController::class,'delete']);
Route::get('/get-module-permissions', [RootPermissionController::class,'getExistingPermissions'])->name('get.module.permissions');

//Admin--------------------------------------------------------------------------------------------------------------------------
    //Usermanagement-Employee management
Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard.show');
Route::get('/user-managements/employee',[UserManagementController::class,'UserManagementView'])->name('new.employee');
Route::post('/add-Emp', [UserManagementController::class, 'addEmp'])->name('add.Emp');
Route::get('/fetch/Employees', [UserManagementController::class, 'fetchEmployees'])->name('users.fetch');
Route::delete('/delete-Emp/{id}', [UserManagementController::class,'deleteEmp'])->name('delete.Emp');
Route::put('/update-Emp-type/{id}', [UserManagementController::class,'updateEmpType'])->name('update.Emp');

     //Usermanagement-Admin management
Route::get('/user-managements/admin',[UserManagementController::class,'AdminManagementView'])->name('new.admins');
Route::post('/add-Admin', [UserManagementController::class, 'addAdmin'])->name('add.admins');
Route::get('/fetch/Admins', [UserManagementController::class, 'fetchAdmins'])->name('admins.fetch');
Route::delete('/delete-Admin/{id}', [UserManagementController::class,'deleteAdmin'])->name('delete.Admin');
Route::get('/get-Admin/{id}', [UserManagementController::class,'getAdmins']);
Route::put('/update-Admin/{id}', [UserManagementController::class,'updateAdmin']);

    //Usermanagement-Client management
Route::get('/user-managements/client',[UserManagementController::class,'ClientManagementView'])->name('new.clients');
Route::post('/add-Client', [UserManagementController::class, 'addClient'])->name('add.clients');
Route::get('/fetch/Clients', [UserManagementController::class, 'fetchClients'])->name('clients.fetch');
Route::delete('/delete-Client/{id}', [UserManagementController::class,'deleteClient'])->name('delete.Client');
Route::get('/get-Client/{id}', [UserManagementController::class,'getClients']);
Route::put('/update-Client/{id}', [UserManagementController::class,'updateClient']);
Route::get('/emp-rates/{userId}', [UserManagementController::class,'getEmpRates']);

    //Support Contract Handling
Route::get('/support-contract/admin-schandling',[SupportContractController::class,'ScIndex'])->name('admin.ScHandling');
Route::post('/support-contract/add-support-contract', [SupportContractController::class, 'addSC'])->name('support-contracts.add');
Route::put('/support-contract/update/{id}', [SupportContractController::class,'updateSC'])->name('support-contracts.update');

    //Support Contract Instance Handling
Route::get('/support-contract/admin-scinstance',[SupportContractInstanceController::class,'ScInstanceIndex'])->name('admin.ScInstance');
Route::post('/support-contract-instances-create', [SupportContractInstanceController::class, 'addScInstances'])->name('support-contract-instances.add');
Route::get('/get-support-contract-instances/{contractId}', [SupportContractInstanceController::class,'getSupportContractInstances']);
Route::get('/get-support-contract-instance-data/{supportContractId}', [SupportContractInstanceController::class,'getSupportContractInstanceData']);



    //SC task monitor
Route::get('/support-contract/sc-task-monitor', [TaskController::class, 'TaskIndex'])->name('scTaskMonitor');
Route::get('/support-contract/sc-task-monitor/sub-task-handle', [TaskController::class, 'subtaskindex']);

Route::post('/sub-task-handle', [TaskController::class, 'subtaskindex'])->name('scsubtaskhandle');

Route::post('/support-contract/tasks', [TaskController::class, 'addTask'])->name('tasks.add');
Route::get('/fetch-support-contract/tasks', [TaskController::class, 'fetchTasks']);
Route::get('/support-contract/sc-all-task-monitor', [TaskController::class, 'AllTaskIndex'])->name('scAllTaskMonitor');
Route::delete('/delete-task/{id}', [TaskController::class,'deleteTask'])->name('delete.Task');
Route::get('/emp-for-tasks', [TaskController::class,'getUEmpForTasks']);
Route::post('/grant-access-tasks', [TaskController::class, 'grantAccess'])->name('grant.access');
Route::post('/revoke-access-tasks', [TaskController::class,'revokeAccess'])->name('revoke.access');
Route::get('/get-task-details/{taskId}', [TaskController::class, 'getTaskDetailsWithEmp']);
    //Sub Task
Route::post('/create-sub-task',  [TaskController::class, 'createSubTask'])->name('create.subtask');
Route::post('/finish-task', [TaskController::class, 'finishTask'])->name('finish.task');
//Route::get('/sub-task-handle', [TaskController::class, 'subtaskindex'])->name('scsubtaskhandle');

    //SC Reports and Views
Route::get('/support-contract/support-contract-view', [ScReportsViewController::class, 'ScView'])->name('scView');
Route::get('/getSupportContract-ChartData', [ScReportsViewController::class,'getSupportContractChartData']);
Route::get('/support-contract/sc-reports', [ScReportsViewController::class, 'ScReportsIndex'])->name('scReports');
Route::get('/getSupportContract-ReportData', [ScReportsViewController::class,'getSupportContractReportData']);


    //Financial Health
Route::get('/performance/financial-health', [SupportPaymentController::class, 'financialHealthIndex'])->name('financialHealth');
Route::get('/getSupportContract-FinancialData', [SupportPaymentController::class,'getFinancialData']);

    //Support Contract Analysis View
Route::get('/performance/analysis-view', [SupportPaymentController::class, 'ScAnalysisIndex'])->name('ScAnalysisView');
Route::get('/getSupportContract-AnalysisData', [SupportPaymentController::class,'getScAnalysisView']);


//All Users
Route::get('/myprofile', [ProfileController::class, 'index'])->name('myprofile');
Route::post('/myprofile/password-change', [ProfileController::class, 'resetPassword'])->name('updatepassword');
Route::post('/myprofile/save-profile-details', [ProfileController::class, 'editProfile'])->name('saveeditprofile');
Route::post('/myprofile/password-change', [ProfileController::class, 'resetPassword'])->name('updatepassword');
//Route::post('/myprofile/save-profile-details', [ProfileController::class, 'editProfile']);

//performace Employee
Route::get('/performance/employee-performance', [EmployeePerformanceController::class, 'index'])->name('employee.performanceemployee');
Route::get('/performance/employee-performance-ind', [EmployeePerformanceController::class, 'subtaskhis']);
Route::post('/support-contract/editinstance', [SupportContractInstanceController::class, 'editinstance']);
