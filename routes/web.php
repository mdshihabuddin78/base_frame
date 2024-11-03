<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RBAC\RoleController;
use App\Http\Controllers\RBAC\ModuleController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\RBAC\RoleModuleController;
use App\Http\Controllers\RBAC\RolePermissionController;


Route::get('/', function () {
    return redirect('/login');
});


Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'doLogin']);
});

Route::get('/home', function () {
    return redirect('/admin/dashboard');
});


Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::view('/admin/{any}', 'backend.index')->where('any', '.*');

    Route::prefix('api')->group(function () {
        Route::post('/configurations', [ConfigurationController::class, 'getConfigurations']);
        Route::post('/file_upload', [UploadController::class, 'uploadFile']);
        Route::post('/image', [UploadController::class, 'imageUpload']);
        Route::resource('/edit_user', UserProfileController::class);
        Route::resource('/users', UserController::class);

        Route::middleware('admin')->group(function () {
            Route::resource('/settings', ConfigurationController::class);
        
            Route::post('/general', [ConfigurationController::class, 'getGeneralData']);
            Route::resource('/modules', ModuleController::class);
            Route::resource('/roles', RoleController::class);
            Route::resource('/module_permissions', RoleModuleController::class);
            Route::resource('/role_permissions', RolePermissionController::class);

            Route::get('/dashboard', [DashboardController::class, 'dashboardData']);
        });
    });
});
