<?php

use App\Http\Controllers\RootPermissionController;
use App\Http\Controllers\DashboardController;
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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// root

Route::get('/root/modulepermission', [RootPermissionController::class, 'index4'])->name('root.modulepermission');
Route::post('/save-module-permission', [RootPermissionController::class, 'save']);


// Route::get('/root-modulepermission', function () {
//     return view('root.modulepermission');
// });
//Route::get('/get-existing-module-permissions', [RootPermissionController::class,'getExistingModulePermissions']);
Route::post('/delete-module-permission', [RootPermissionController::class,'delete']);
Route::get('/get-module-permissions', [RootPermissionController::class,'getExistingPermissions'])->name('get.module.permissions');

//Admin

Route::get('/admin/usermanagement', function(){
    return view('admin.usermanagement');
});

Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard.show');
