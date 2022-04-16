<?php
session_start();
use Illuminate\Support\Facades\Route;

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

Route::get('/loglog', function () {
    return view('login');
});

Route::get('/mail', function () {
    return view('mails/verification');
});

use App\Http\Controllers\Api\UsersController;
Route::get('/user/register', [UsersController::class,'authToken']);

Route::get('/user/login', function () {
    return view('user');
})->middleware('login');

use App\Http\Controllers\Api\passwordController;
Route::get('/user/resetP', [passwordController::class,'authUrl']);
