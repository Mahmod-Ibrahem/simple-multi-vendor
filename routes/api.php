<?php

use App\Http\Controllers\Api\AssignmentController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\LetterAttachmentController;
use App\Http\Controllers\Api\LetterController;
use App\Http\Controllers\Api\LetterStatusController;
use App\Http\Controllers\Api\SubjectController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\Api\NotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Public Routes (مسارات عامة)
|--------------------------------------------------------------------------
*/

Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/me', [AuthController::class, 'me'])->name('auth.me');

    /*
|--------------------------------------------------------------------------
| User Management Routes (مسارات إدارة المستخدمين)
|--------------------------------------------------------------------------
*/
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::post('/', [UserController::class, 'store'])->name('users.store');
        Route::get('/{user}', [UserController::class, 'show'])->name('users.show');
        Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
        Route::post('/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // RBAC Routes (Super Admin Only)
    Route::get('roles', [RoleController::class, 'index']); // Allow listing roles for other auth users (e.g. for filtering)
    Route::middleware(['auth:sanctum', 'role:مدير النظام'])->group(function () {
        Route::apiResource('roles', RoleController::class)->except(['index']);
        Route::post('roles/{role}/permissions', [RoleController::class, 'syncPermissions']);
        Route::apiResource('permissions', PermissionController::class);
        Route::post('setting/update', [SettingController::class, 'update'])->name('setting.update');
        Route::apiResource('setting', SettingController::class)->names('setting')->except(['update']);
    });
});
