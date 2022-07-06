<?php

// use App\Http\Controllers\API\Auth\AuthController;
// use App\Http\Controllers\API\Operation\OperationController;
// use App\Http\Controllers\API\User\UserController;
// use App\Http\Controllers\API\User\ShippingController;
// use App\Http\Controllers\API\User\InchargeController;
// use App\Http\Controllers\API\Master\MasterController;
// use App\Http\Controllers\API\Search\RequestInfoController;
// use App\Http\Controllers\Parts\PartsController;
// use App\Http\Controllers\API\Order\OrderController;
// use Illuminate\Support\Facades\Route;

// // Admin
// use App\Http\Controllers\API\Admin\User\IndexController as UserIndex;
// use App\Http\Controllers\API\Admin\User\ShowController as UserShow;
// use App\Http\Controllers\API\Admin\User\UpdateController as UserUpdate;


// /*
// |--------------------------------------------------------------------------
// | API Routes
// |--------------------------------------------------------------------------
// |
// | Here is where you can register API routes for your application. These
// | routes are loaded by the RouteServiceProvider within a group which
// | is assigned the "api" middleware group. Enjoy building your API!
// |
// */

// Route::prefix('user')->group(function () {
//     Route::post('/login', [AuthController::class, 'login']);
//     Route::put('/login/reset_password', [AuthController::class, 'resetPassword']);
//     Route::put('/login/reset_password_email', [AuthController::class, 'sendResetPasswordMail']);
//     Route::post('/email/register', [AuthController::class, 'registerEmail']);
//     Route::get('/email/verification', [AuthController::class, 'verifyEmail']);
//     Route::post('/info/register', [UserController::class, 'registerUserInfo']);

//     Route::middleware('auth:api')->group(function () {
//         Route::post('/incharge/register', [InchargeController::class, 'registerIncharge']);
//         Route::put('/incharge/delete', [InchargeController::class, 'deleteIncharge']);
//         Route::get('/incharge/list', [InchargeController::class, 'listIncharges']);
//         Route::put('/incharge/update', [InchargeController::class, 'updateIncharge']);

//         Route::get('/mypage/info', [UserController::class, 'myPageInfo']);
//         Route::put('/info/update_image', [UserController::class, 'updateUserInfoImage']);
//         Route::put('/info/update', [UserController::class, 'updateUserInfo']);

//         Route::post('/shipping/register', [ShippingController::class, 'registerShipping']);
//         Route::put('/shipping/update', [ShippingController::class, 'updateShipping']);
//         Route::get('/shipping/list', [ShippingController::class, 'listShipping']);
//     });
// });

// Route::prefix('master')->group(function () {
//     Route::get('/prefecture/data', [MasterController::class, 'getPrefectureData']);
//     Route::get('/prefecture/info', [MasterController::class, 'getPrefectureInfo']);
//     Route::post('/verify/token', [MasterController::class, 'verifyToken']);
//     Route::get('/makers/info', [MasterController::class, 'getMakersInfo']);
//     Route::get('/cars/info', [MasterController::class, 'getCarsInfo']);
//     Route::get('/car_models/info', [MasterController::class, 'getCarModelsInfo']);
//     Route::get('/exterior_colors/info', [MasterController::class, 'getExteriorColorsInfo']);
//     Route::get('/parts/info', [MasterController::class, 'getPartsInfo']);
// });

// Route::prefix('search')->group(function () {
//     Route::get('/vehicle_no/info', [OperationController::class, 'getVehicleNoInfo']);
//     Route::get('/product_comments/info', [RequestInfoController::class, 'getProductComments']);
//     Route::get('/parts_same_vin/info', [OperationController::class, 'getPartsSameVinInfo']);
//     Route::middleware('auth:api')->group(function () {
//         Route::post('/favorite/create', [OperationController::class, 'createDeleteFavorite']);
//         Route::get('/favorite/info', [OperationController::class, 'getFavoriteInfo']);
//         Route::post('/request/create', [RequestInfoController::class, 'requestInfoCreate']);
//         Route::post('/product_comments/create', [OperationController::class, 'createProductComments']);
//         Route::delete('/favorite/update', [OperationController::class, 'DeleteFavorite']);
//     });
//     Route::get('/products/count', [OperationController::class, 'getNumberOfProducts']);
// });

// Route::prefix('parts')->group(function () {
//     Route::get('/list/info', [PartsController::class, 'getItemListInfo']);
//     Route::get('/detail/info', [PartsController::class, 'getItemDetailInfo']);
// });

// Route::prefix('order')->group(function () {
//     Route::middleware('auth:api')->group(function () {
//         Route::post('/cart/create', [OrderController::class, 'CreateCartInfo']);
//         Route::put('/cart/update', [OrderController::class, 'UpdateCartInfo']);
//     });
// });

// // AdminAPI
// Route::prefix('admin')->group(function () {
//     Route::prefix('users')->group(function () {
//         // GET /api/admin/users
//         Route::get('/', UserIndex::class);
//         // GET /api/admin/users/{user_id}
//         Route::get('/{user}', UserShow::class);
//         // PUT /api/admin/users/{user_id}
//         Route::put('/{user}', UserUpdate::class);
//     });
// });

use App\Http\Controllers\DemoAppControllers\EmailAuthenticationController;

Route::post('/email_store', [EmailAuthenticationController::class, 'store'])
    ->name('email_authentications.store');
