<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\SetupController;

/*
|--------------------------------------------------------------------------
| Setup Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Setup routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "Web" middleware group. Now create something great!
|
*/

Route::get('start', [SetupController::class, 'welcome'])
    ->name('welcome');
Route::get('requirements', [SetupController::class, 'requirements'])
    ->name('requirements');
Route::get('database', [SetupController::class, 'databaseConfiguration'])
    ->name('database');
Route::post('database', [SetupController::class, 'databaseConfigurationStore'])
    ->name('save-database');
Route::get('account', [SetupController::class, 'accountCreate'])
    ->name('account');
Route::post('account', [SetupController::class, 'accountStore'])
    ->name('save-account');
Route::get('setting', [SetupController::class, 'settingCreate'])
    ->name('setting.create');
Route::post('setting', [SetupController::class, 'settingStore'])
    ->name('setting.save');
Route::get('Setup-complete', [SetupController::class, 'complete'])
    ->name('complete');
