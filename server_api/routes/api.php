<?php

use App\Http\Controllers\api\v1\cartController;
use App\Http\Controllers\api\v1\categoryController;
use App\Http\Controllers\api\v1\couponController;
use App\Http\Controllers\api\v1\permissionController;
use App\Http\Controllers\api\v1\productController;
use App\Http\Controllers\api\v1\resourceController;
use App\Http\Controllers\api\v1\roleController;
use App\Http\Controllers\api\v1\sliderController;
use App\Http\Controllers\api\v1\userController;
use App\Models\User;
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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 */

 /*  $this->middleware('auth:api', ['except' => ['login', 'store','paginate']]); */

 Route::prefix('v1')->group(function(){
    Route::middleware('auth:api')->group(function(){
        //router product
        Route::post('product',[productController::class,'store']);
        Route::put('product/{id}',[productController::class,'update']);
        Route::delete('product/{id}',[productController::class,'destroy']);
        //router category
        Route::post('category',[categoryController::class,'store']);
        Route::put('category/{id}',[categoryController::class,'update']);
        Route::delete('category/{id}',[categoryController::class,'destroy']);
        //router slider
        Route::post('slider',[sliderController::class,'store']);
        Route::put('slider/{id}',[sliderController::class,'update']);
        Route::delete('slider/{id}',[sliderController::class,'destroy']);
        //router user
        Route::get('users/logout',[userController::class,'logout'])->name('user.logout');
        Route::post('users/refresh_token',[userController::class,'refresh_token'])->name('user.refresh_token');
        Route::get('users/index/{record_number}',[userController::class,'index']);
        Route::get('user/{id}',[userController::class,'show']);
        Route::put('user/{id}',[userController::class,'update']);
        Route::delete('user/{id}',[userController::class,'destroy']);
        Route::get('users/user_login',[userController::class,'user_login']);
        Route::post('users/updateCustomer',[userController::class,'updateCustomer']);
        Route::post('users/addDeliveryInformation',[userController::class,'addDeliveryInformation']);
        Route::get('users/deleteDeliveryInformation',[userController::class,'deleteDeliveryInformation']);
        //router role
        Route::post('role',[roleController::class,'store']);
        Route::delete('role/{id}',[roleController::class,'destroy']);
        Route::put('role/{id}',[roleController::class,'update']);
        //router resource
        Route::post('resource',[resourceController::class,'store']);
        Route::put('resource/{id}',[resourceController::class,'update']);
        Route::delete('resource/{id}',[resourceController::class,'delete']);
        //router cart
        Route::post('cart',[cartController::class,'add_product']);
        Route::put('cart',[cartController::class,'update_product']);
        Route::delete('cart',[cartController::class,'delete_product']);
        //router coupon
        Route::get('coupon/index/{record_number}',[couponController::class,'index']);
        Route::post('coupon',[couponController::class,'store']);
        Route::put('coupon/{id}',[couponController::class,'update']);
        Route::delete('coupon/{id}',[couponController::class,'destroy']);
        //router permission
        Route::post('permission',[permissionController::class,'store']);
    });

    // NOT REQUIRE LOGIN

    //router product
    Route::get('product/index/{record_number}',[productController::class,'index'])/* ->middleware('checkPermission:slider,index') */;
    Route::get('product/{id}',[productController::class,'show']);
    //router category
    Route::get('category/index/{record_number}',[categoryController::class,'index']);
    Route::get('category/{id}',[categoryController::class,'show']);
    //router slider
    Route::get('slider/index/{record_number}',[sliderController::class,'index']);
    Route::get('slider/{id}',[sliderController::class,'show']);
    //router user
    Route::post('users/login',[userController::class,'login'])->name('user.login');
    Route::post('user',[userController::class,'store']);
    Route::post('sendCodeToEmail',[userController::class,'sendCodeToEmail']);
    //router role
    Route::get('role/index/{record_number}',[roleController::class,'index']);
    Route::get('role/{id}',[roleController::class,'show']);
    //router resource
    Route::get('resource/index/{record_number}',[resourceController::class,'index']);
    Route::get('resource/{id}',[resourceController::class,'show']);
    //router cart
    Route::get('cart',[cartController::class,'show']);
    //router coupon
    Route::get('coupon/{id}',[couponController::class,'show']);
    
});


