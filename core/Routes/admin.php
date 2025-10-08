<?php

use Core\Http\Controllers\Admin\DashboardController;
use Core\Http\Controllers\Admin\LoginController;
use Core\Http\Livewire\Admin\Dashboard;
use Illuminate\Support\Facades\Route;


//// Chráněné routy
//Route::middleware(['auth'])->group(function () {
//
//    // Routy pro články - kontrola oprávnění
//    Route::middleware(['permission:view posts'])->group(function () {
//        Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
//    });
//
//    Route::middleware(['permission:create posts'])->group(function () {
//        Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
//        Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
//    });
//
//    Route::middleware(['permission:edit posts'])->group(function () {
//        Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
//        Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
//    });
//
//    // Admin sekce - jen pro adminy
//    Route::middleware(['role:admin|super-admin'])->prefix('admin')->group(function () {
//        Route::get('/dashboard', [AdminController::class, 'dashboard']);
//        Route::resource('users', UserController::class);
//    });
//
//    // Super admin sekce
//    Route::middleware(['role:super-admin'])->prefix('super-admin')->group(function () {
//        Route::get('/settings', [SettingsController::class, 'index']);
//    });
//});


Route::middleware(['web'])->group(function () {
    Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');
    Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [LoginController::class, 'login'])->name('admin.login.post');
    Route::middleware(['auth', 'role:super-admin|admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', Dashboard::class)->name('admin.dashboard');
    });
});
