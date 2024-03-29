<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware('auth')->group(function () {
    Route::view('dashboard', 'dashboard')->middleware(['verified'])->name('dashboard');
    Route::view('profile', 'profile')->name('profile');
    Route::view('incomes', 'income.index')->name('income.index');
    Route::view('incomes/create', 'income.create')->name('income.create');
    Route::view('incomes/{income}/edit', 'income.edit')->name('income.edit');
    Route::view('expenses', 'expense.index')->name('expense.index');
    Route::view('expenses/create', 'expense.create')->name('expense.create');
    Route::view('expenses/{expense}/edit', 'expense.edit')->name('expense.edit');
    Route::view('transactions', 'transaction.index')->name('transaction.index');
    Route::view('transactions/create', 'transaction.create')->name('transaction.create');
    Route::view('transactions/{transaction}/edit', 'transaction.edit')->name('transaction.edit');
});

require __DIR__ . '/auth.php';
