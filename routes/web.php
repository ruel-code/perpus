<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::middleware([])->group(function () {
    Route::get('/dashboard', fn() => view('pages.dashboard'))->name('dashboard');
    Route::get('/catalog', fn() => view('pages.catalog'))->name('catalog');
    Route::get('/books', fn() => view('pages.books'))->name('books');
    Route::get('/categories', fn() => view('pages.categories'))->name('categories');
    Route::get('/my-loans', fn() => view('pages.my-loans'))->name('my-loans');
    Route::get('/loans', fn() => view('pages.loans'))->name('loans');
    Route::get('/fines', fn() => view('pages.fines'))->name('fines');
    Route::get('/users', fn() => view('pages.users'))->name('users');
    Route::get('/reports', fn() => view('pages.reports'))->name('reports');
    Route::get('/settings', fn() => view('pages.settings'))->name('settings');
    Route::get('/profile', fn() => view('pages.profile'))->name('profile');
});
