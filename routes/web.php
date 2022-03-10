<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // If user session is logged in, redirect to dashboard
    if (session()->has('_token')) {
        return redirect('/dashboard');
    }
    return view('auth/login');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/grades', function () {
    return view('grades');
})->name('grades');

Route::middleware(['auth:sanctum', 'verified'])->get('/ranking', function () {
    return view('ranking');
})->name('ranking');
