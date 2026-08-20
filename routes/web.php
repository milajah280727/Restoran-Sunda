<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Livewire\Dashboard;

Route::view('/', 'pages.auth.login')->name('home');

// Route untuk login/register dengan middleware redirect berdasarkan role
Route::middleware(['guest'])->group(function () {
    Route::get('login', function () {
        return view('pages.auth.login');
    })->name('login');

    Route::get('register', function () {
        return view('pages.auth.register');
    })->name('register');
});

// Route yang memerlukan autentikasi
Route::middleware(['auth', 'verified', 'roledashboard'])->group(function () {
    // Dashboard User Biasa
    Route::get('dashboard', function () {
        return view('users.dashboard');
    })->name('dashboard');

    // Dashboard Admin
    Route::get('admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Dashboard Owner
    Route::get('owner/dashboard', function () {
        return view('owner.dashboard');
    })->name('owner.dashboard');


});

require __DIR__.'/settings.php';
