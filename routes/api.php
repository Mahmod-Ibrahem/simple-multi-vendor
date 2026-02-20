<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SettingController;



// RBAC Routes (Super Admin Only)
Route::middleware(['auth:sanctum', 'role:مدير النظام'])->group(function () {
    Route::post('setting/update', [SettingController::class, 'update'])->name('setting.update');
    Route::apiResource('setting', SettingController::class)->names('setting')->except(['update']);
});
