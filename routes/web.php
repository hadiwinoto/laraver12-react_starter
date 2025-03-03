<?php

use App\Http\Controllers\Management\UserManagementController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});


Route::middleware(['auth', 'verified', 'role:administrator'])->group(function () {
    Route::get('management', [UserManagementController::class, 'showManagementPage'])->name('management');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
