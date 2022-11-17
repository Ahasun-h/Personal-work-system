<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\BankController;
use App\Http\Controllers\Web\BranchController;
use App\Http\Controllers\Web\AccountController;
use App\Http\Controllers\Web\ExpenseController;
use App\Http\Controllers\Web\AccountBalanceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "Web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();



Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Bank
    Route::resource('bank',BankController::class);
    Route::get('bank/status/{id}',[BankController::class,'status'])->name('bank.status');

    // Branch
    Route::resource('branch',BranchController::class);
    Route::get('branch/status/{id}',[BranchController::class,'status'])->name('branch.status');

    // Account
    Route::resource('account',AccountController::class)->except('destroy');
    Route::get('account/status/{id}',[AccountController::class,'status'])->name('account.status');
    Route::get('account/default-account-update/{id}',[AccountController::class,'defaultAccountUpdate'])->name('account.default-account-update');

    // Expense
     Route::resource('expense',ExpenseController::class);

     // Get Account Balance
    Route::get('get-accout-balance/{id}' , [AccountBalanceController::class,'getAccountBalance'])->name('get-account-balance');



});
