<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\LoanController;
use App\Http\Controllers\Api\FineController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\SettingController;

// Public routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', function (Request $request) {
        return $request->user();
    });

    // --- Category Management ---
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{category}', [CategoryController::class, 'show']);

    Route::middleware('role:admin')->group(function () {
        Route::post('categories', [CategoryController::class, 'store']);
        Route::put('categories/{category}', [CategoryController::class, 'update']);
        Route::delete('categories/{category}', [CategoryController::class, 'destroy']);
    });

    // --- Book Management ---
    Route::get('books', [BookController::class, 'index']);
    Route::get('books/{book}', [BookController::class, 'show']);

    Route::middleware('role:admin')->group(function () {
        Route::post('books', [BookController::class, 'store']);
        Route::put('books/{book}', [BookController::class, 'update']);
        Route::delete('books/{book}', [BookController::class, 'destroy']);
    });

    // --- Loan Management ---
    Route::get('loans', [LoanController::class, 'index']);
    Route::get('loans/{loan}', [LoanController::class, 'show']);

    Route::middleware('role:admin,user')->group(function () {
        Route::post('loans', [LoanController::class, 'store']);
    });

    Route::middleware('role:admin')->group(function () {
        Route::put('loans/{loan}/approve', [LoanController::class, 'approve']);
        Route::put('loans/{loan}/reject', [LoanController::class, 'reject']);
        Route::put('loans/{loan}/return', [LoanController::class, 'update']);
    });

    // --- Fine Management ---
    Route::middleware('role:admin')->group(function () {
        Route::get('fines', [FineController::class, 'index']);
        Route::get('fines/{fine}', [FineController::class, 'show']);
        Route::put('fines/{fine}/status', [FineController::class, 'update']);
    });

    // --- User Management (Admin only) ---
    Route::middleware('role:admin')->group(function () {
        Route::apiResource('users', UserController::class)->except(['create', 'edit']);
        Route::put('users/{user}/reset-password', [UserController::class, 'resetPassword']);
        Route::put('users/{user}/toggle-active', [UserController::class, 'toggleActive']);
    });

    // --- Profile (own) ---
    Route::get('profile', [\App\Http\Controllers\Api\ProfileController::class, 'show']);
    Route::put('profile', [\App\Http\Controllers\Api\ProfileController::class, 'update']);
    Route::put('profile/password', [\App\Http\Controllers\Api\ProfileController::class, 'password']);
    Route::post('profile/photo', [\App\Http\Controllers\Api\ProfileController::class, 'photo']);

    // --- Cancel own loan (user role) ---
    Route::put('loans/{loan}/cancel', [LoanController::class, 'cancel'])->middleware('role:user,admin');

    // --- E-book serve (all roles) ---
    Route::get('books/{book}/ebook', [\App\Http\Controllers\Api\BookController::class, 'ebook']);

    // --- Dashboard ---
    Route::get('dashboard/stats', [DashboardController::class, 'stats']);
    Route::get('dashboard/chart', [DashboardController::class, 'chartData']);

    // --- Settings (Admin only) ---
    Route::middleware('role:admin')->group(function () {
        Route::get('settings', [SettingController::class, 'index']);
        Route::post('settings', [SettingController::class, 'update']);
        Route::post('settings/backup', [SettingController::class, 'backup']);
    });
});
