<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::middleware([])->group(function () {
    Route::get('/dashboard', function () {
        return view('pages.dashboard');
    })->name('dashboard');

    Route::get('/catalog', function () {
        return view('pages.catalog');
    })->name('catalog');

    Route::get('/books', function () {
        return view('pages.books');
    })->name('books');

    Route::get('/my-loans', function () {
        return view('pages.my-loans');
    })->name('my-loans');

    Route::get('/loans', function () {
        return view('pages.loans');
    })->name('loans');

    Route::get('/fines', function () {
        return view('pages.fines');
    })->name('fines');
});
