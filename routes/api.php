<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\LoanController;
use App\Http\Controllers\Api\FineController;
use App\Http\Controllers\Api\AuthController;

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
    // All authenticated users can view categories for filtering/selection
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{category}', [CategoryController::class, 'show']);

    // Admin only can manage (create, update, delete)
    Route::middleware('role:admin')->group(function () {
        Route::post('categories', [CategoryController::class, 'store']);
        Route::put('categories/{category}', [CategoryController::class, 'update']);
        Route::delete('categories/{category}', [CategoryController::class, 'destroy']);
    });

    // --- Book Management ---
    // Public (authenticated): index, show
    Route::get('books', [BookController::class, 'index']);
    Route::get('books/{book}', [BookController::class, 'show']);
    // Staff/Admin only: store, update, destroy
    Route::middleware('role:admin,petugas')->group(function () {
        Route::post('books', [BookController::class, 'store']);
        Route::put('books/{book}', [BookController::class, 'update']);
        Route::delete('books/{book}', [BookController::class, 'destroy']);
    });

    // --- Loan Management ---
    // Index & Show for all authenticated users
    Route::get('loans', [LoanController::class, 'index']);
    Route::get('loans/{loan}', [LoanController::class, 'show']);
    
    // Mahasiswa & Admin can borrow
    Route::middleware('role:admin,mahasiswa')->group(function () {
        Route::post('loans', [LoanController::class, 'store']);
    });

    // Petugas & Admin can handle returns
    Route::middleware('role:admin,petugas')->group(function () {
        Route::put('loans/{loan}/return', [LoanController::class, 'update']);
    });

    // --- Fine Management ---
    // Admin & Petugas can see fines
    Route::middleware('role:admin,petugas')->group(function () {
        Route::get('fines', [FineController::class, 'index']);
        Route::get('fines/{fine}', [FineController::class, 'show']);
    });
    // Admin only can update fine payment status
    Route::middleware('role:admin')->group(function () {
        Route::put('fines/{fine}/status', [FineController::class, 'update']);
    });
});
