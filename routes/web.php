<?php

use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Auth;
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
    // If user session is logged in, redirect to dashboard or dashboard-admin
    if (Auth::check()) {
        if (Auth::user()->isAdmin()) {
            return redirect()->route('dashboard-admin');
        } else {
            return redirect()->route('dashboard');
        }
    }

    return view('auth/login');
});

Route::middleware(['auth:sanctum', 'verified', 'student'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified', 'student'])->get('/grades', function () {
    return view('grades');
})->name('grades');

Route::middleware(['auth:sanctum', 'verified', 'student'])->get('/ranking', function () {
    return view('ranking');
})->name('ranking');

Route::middleware(['auth:sanctum', 'verified', 'admin'])
    ->get(
        '/dashboard-admin',
        [FileController::class, 'index']
    )
    ->name('dashboard-admin');

Route::middleware(['auth:sanctum', 'verified', 'admin'])
    ->post(
        '/upload-mecc',
        [FileController::class, 'uploadMecc']
    )->name('upload-mecc');

Route::middleware(['auth:sanctum', 'verified', 'admin'])
    ->get(
        '/grades-template',
        [FileController::class, 'downloadGradesTemplate']
    )->name('grades-template');
