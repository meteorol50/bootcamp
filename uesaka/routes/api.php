<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

#/hello名前空間を指定された時に{"message":"Hello"}を返す無名関数を実行する。
Route::get('/hello', function () {
    $message = 'Hello';
    return response()->json([
    'message' => $message
    ]);
   });

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

#app\Http\Controllers名前空間に定義したクラスhnbSearchをインポート
use App\Http\Controllers\hnbSearch;
Route::get('/hnb/{vin}/{hcode}', [hnbSearch::class,'Search']);


use App\Http\Controllers\mailverify;
Route::post('/mail', [mailverify::class,'create'])->name('user.create');

use App\Http\Controllers\Api\passwordController;
Route::post('/reset', [passwordController::class,'resetUrl'])->name('user.resetP');

use App\Http\Controllers\Api\changePassword;
Route::post('/change', [changePassword::class,'changeP'])->name('user.changeP')->middleware('login');

use App\Http\Controllers\LoginController;
Route::post('/login/email', [LoginController::class,'login'])->name('user.login');

use App\Http\Controllers\Api\UsersController;
Route::post('/login/data', [UsersController::class,'getData'])->name('user.data')->middleware('login');
