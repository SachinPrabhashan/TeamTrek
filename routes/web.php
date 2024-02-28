<?php

use App\Http\Controllers\RootPermissionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\RoleViewController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/permissions/manage-modules', [RootPermissionController::class, 'index3'])->name('root.modules');
Route::post('/save-module', [RootPermissionController::class, 'addmodule']);




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


//All Users
Route::get('/myprofile', [ProfileController::class, 'index'])->name('myprofile');
Route::post('/myprofile/save-profile-details', [ProfileController::class, 'editProfile'])->name('saveeditprofile');
Route::post('/myprofile/password-change', [ProfileController::class, 'resetPassword'])->name('updatepassword');
Route::post('/myprofile/save-profile-details', [ProfileController::class, 'editProfile']);
