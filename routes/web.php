<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware('auth')->group(function () {
    Route::view('dashboard', 'dashboard')->middleware(['verified'])->name('dashboard');
    Route::view('profile', 'profile')->name('profile');
    Route::view('incomes', 'income.index')->name('income.index');
    Route::view('incomes/create', 'income.create')->name('income.create');
    Route::view('incomes/{income}/edit', 'income.edit')->name('income.edit');
});

require __DIR__ . '/auth.php';
