<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DemoAppControllers\UserController;

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
    return view('welcome');
});

Route::get('/registration', [UserController::class, 'create'])
    ->name('email_authentications.create');

Route::get('/authentication', [UserController::class, 'input_code'])
    ->name('email_authentications.input_code');

Route::get('/completion', [UserController::class, 'complete'])
    ->name('email_authentications.complete');
