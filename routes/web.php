<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Expense\ExpenseController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Order\OrderController;

Route::get('/', function () {
    return view('Frontend.index');
});

Auth::routes();

Route::get('/expense', [DashboardController::class, 'index']);

Route::prefix('admin')->middleware(['auth'])->group(function() {

   Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
 

   Route::prefix('expesnse')->group(function() {

       Route::get('/show', [ExpenseController::class, 'index'])->name('expenses.index');
       Route::post('/store', [ExpenseController::class, 'store'])->name('expenses.store');
       Route::put('/update/{id}', [ExpenseController::class, 'update'])->name('expenses.update');
       Route::delete('/destroy/{id}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');
    
    // Additional routes
    // Route::get('/summary', [ExpenseController::class, 'getSummary'])->name('summary');
    // Route::get('/export', [ExpenseController::class, 'export'])->name('export');

   });

   Route::prefix('customers')->group(function() {

    Route::get('/show', [CustomerController::class, 'index'])->name('customers.index');
    Route::post('/store', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/{id}', [CustomerController::class, 'show'])->name('customers.show');
    Route::put('/update/{id}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/destroy/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    
    // Additional routes
    Route::get('/summary', [CustomerController::class, 'getSummary'])->name('summary');
    Route::get('/export', [CustomerController::class, 'export'])->name('export');
    Route::post('/import', [CustomerController::class, 'import'])->name('import');

   });


   Route::prefix('orders')->group(function() {
       Route::get('show', [OrderController::class, 'index'])->name('orders.index');
           Route::post('/store', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/update/{id}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/destroy/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');


       // Additional routes
    Route::get('/summary', [OrderController::class, 'getSummary'])->name('summary');
    Route::get('/export', [OrderController::class, 'export'])->name('export');
    Route::put('/update-status/{id}', [OrderController::class, 'updateStatus'])->name('update-status');
    Route::get('/statistics', [OrderController::class, 'getStatistics'])->name('statistics');


   });

});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
