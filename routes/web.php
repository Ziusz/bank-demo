<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [ClientController::class, 'index'])->name('dashboard')->middleware(['auth', 'verified']);

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/admin/users/create', [AdminUserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit')->whereNumber('user');
    Route::patch('/admin/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update')->whereNumber('user');
    Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy')->whereNumber('user');
});

Route::middleware(['auth', 'verified', 'role:admin|customer-support'])->group(function () {
    Route::get('/admin', function () { return redirect()->route('admin.users.index'); })->name('admin.index');
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/{user}', [AdminUserController::class, 'show'])->name('admin.users.show')->whereNumber('user');
});

Route::get('/client', [ClientController::class, 'index'])->middleware('role:client', 'verified');
Route::get('/support', [SupportController::class, 'index'])->middleware('role:customer-support', 'verified');

Route::get('/transactions', [TransactionController::class, 'create'])->name('transactions.create')->middleware('auth', 'verified');
Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store')->middleware('auth', 'verified');

require __DIR__.'/auth.php';
