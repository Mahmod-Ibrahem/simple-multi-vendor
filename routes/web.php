<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VerificationController;

// Public Routes
Route::get('/', [HomeController::class, 'intro'])->name('intro');
Route::prefix('shop')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/products/{product:slug}', [HomeController::class, 'show'])->name('products.show');
    Route::post('/products/{product}/whatsapp-click', [HomeController::class, 'trackWhatsapp'])->name('products.track-whatsapp');
    Route::get('/users/{user:slug}/products', [CategoryController::class, 'userProducts'])->name('users.products');;

    // Auth Routes (Guest)
    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Email Verification Routes (Auth required)
    Route::middleware('auth')->group(function () {
        Route::get('/email/verify', [VerificationController::class, 'notice'])->name('verification.notice');
        Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware('signed')->name('verification.verify');
        Route::post('/email/verification-notification', [VerificationController::class, 'send'])->middleware('throttle:6,1')->name('verification.send');
    });

    Route::name('admin.')->prefix('admin')->middleware(['auth', 'verified'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Products: accessible by all roles — policy enforces ownership scoping
        Route::resource('products', ProductController::class);

        // Profile: accessible by all authenticated users
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

        // Admin-only routes: Users, Categories, Roles, Permissions
        Route::middleware(['role:مدير النظام'])->group(function () {
            Route::post('users/{user}/verify', [UserController::class, 'verify'])->name('users.verify');
            Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
            Route::resource('users', UserController::class);
            Route::resource('categories', AdminCategoryController::class);
            Route::resource('roles', RoleController::class);
            Route::resource('permissions', PermissionController::class);
        });
    });
});
