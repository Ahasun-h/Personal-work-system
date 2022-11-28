<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\BankController;
use App\Http\Controllers\Web\BranchController;
use App\Http\Controllers\Web\AccountController;
use App\Http\Controllers\Web\ExpenseOrWithdrawController;
use App\Http\Controllers\Web\AccountBalanceController;
use App\Http\Controllers\Web\IncomeOrDepositController;
use App\Http\Controllers\Web\FundTransferController;
use App\Http\Controllers\Web\BalanceSheetController;
use App\Http\Controllers\Web\SettingController;
use App\Http\Controllers\Web\UserUpdateController;

/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Backend routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "Web" middleware group. Now create something great!
|
*/

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

// Expense Or Withdraw
Route::resource('expense-or-withdraw',ExpenseOrWithdrawController::class);

// Income Or Deposit
Route::resource('income-or-deposit',IncomeOrDepositController::class);

// Fund Transfer
Route::resource('fund-transfer',FundTransferController::class);

// Balance Sheet
Route::get('account-balance-sheet',[BalanceSheetController::class,'accountBalanceSheet'])->name('account.balance-sheet');
Route::get('account-statement/{id}',[BalanceSheetController::class,'accountStatement'])->name('account.statement');

// Setting
Route::get('setting',[SettingController::class,'index'])->name('setting');
Route::post('setting-update',[SettingController::class,'update'])->name('setting.update');

// User Update
Route::get('user-profile',[UserUpdateController::class,'userProfile'])->name('user.profile');
Route::post('user-update',[UserUpdateController::class,'update'])->name('user.update');

// User Password Change
Route::get('user-password',[UserUpdateController::class,'userPassword'])->name('user.password');
Route::post('user-password/update',[UserUpdateController::class,'userPasswordUpdate'])->name('user.password-update');

// Get Account Balance
Route::get('get-accout-balance/{id}' , [AccountBalanceController::class,'getAccountBalance'])->name('get-account-balance');
