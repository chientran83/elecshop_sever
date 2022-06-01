<?php
use App\Http\Controllers\api\v1\cartController;
use App\Http\Controllers\api\v1\categoryController;
use App\Http\Controllers\api\v1\couponController;
use App\Http\Controllers\api\v1\orderController;
use App\Http\Controllers\api\v1\PayPalController;
use App\Http\Controllers\api\v1\permissionController;
use App\Http\Controllers\api\v1\productController;
use App\Http\Controllers\api\v1\resourceController;
use App\Http\Controllers\api\v1\roleController;
use App\Http\Controllers\api\v1\sliderController;
use App\Http\Controllers\api\v1\statisticController;
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

 Route::prefix('v1')->group(function(){
        Route::middleware('auth:api')->group(function(){
        //search
        Route::post('search',[statisticController::class,'search'])/* ->middleware('checkPermission:statistic,filterBySelect') */;
        //router product
        Route::post('product',[productController::class,'store'])->middleware('checkPermission:product,store');
        Route::put('product/{id}',[productController::class,'update'])->middleware('checkPermission:product,update');
        Route::delete('product/{id}',[productController::class,'destroy'])->middleware('checkPermission:product,destroy');
        //router category
        Route::post('category',[categoryController::class,'store'])->middleware('checkPermission:category,destroy');
        Route::put('category/{id}',[categoryController::class,'update'])->middleware('checkPermission:category,update');
        Route::delete('category/{id}',[categoryController::class,'destroy'])->middleware('checkPermission:category,destroy');
        //router slider
        Route::post('slider',[sliderController::class,'store'])->middleware('checkPermission:slider,destroy');
        Route::put('slider/{id}',[sliderController::class,'update'])->middleware('checkPermission:slider,update');
        Route::delete('slider/{id}',[sliderController::class,'destroy'])->middleware('checkPermission:slider,destroy');
        //router user
        Route::post('users/refresh_token',[userController::class,'refresh_token']);
        Route::get('users/index/{record_number}',[userController::class,'index'])->middleware('checkPermission:user,index');
        Route::get('user/{id}',[userController::class,'show']);
        Route::put('user/{id}',[userController::class,'update'])->middleware('checkPermission:user,update');
        Route::delete('user/{id}',[userController::class,'destroy'])->middleware('checkPermission:user,destroy');
        Route::get('users/user_login',[userController::class,'user_login']);
        Route::post('users/updateCustomer',[userController::class,'updateCustomer']);
        Route::post('users/addDeliveryInformation',[userController::class,'addDeliveryInformation']);
        Route::get('users/deleteDeliveryInformation',[userController::class,'deleteDeliveryInformation']);
        Route::get('users/logout',[userController::class,'logout']);
        //router role
        Route::post('role',[roleController::class,'store'])->middleware('checkPermission:role,destroy');
        Route::delete('role/{id}',[roleController::class,'destroy'])->middleware('checkPermission:role,destroy');
        Route::put('role/{id}',[roleController::class,'update'])->middleware('checkPermission:role,update');
        //router resource
        Route::post('resource',[resourceController::class,'store'])->middleware('checkPermission:resource,store');
        Route::put('resource/{id}',[resourceController::class,'update'])->middleware('checkPermission:resource,update');
        Route::delete('resource/{id}',[resourceController::class,'delete'])->middleware('checkPermission:resource,delete');
        //router cart
        Route::get('cart',[cartController::class,'show']);
        Route::post('cart',[cartController::class,'add_product']);
        Route::put('cart',[cartController::class,'update_product']);
        Route::delete('cart',[cartController::class,'delete_product']);
        //router coupon
        Route::get('coupon/index/{record_number}',[couponController::class,'index'])->middleware('checkPermission:coupon,delete');
        Route::post('coupon',[couponController::class,'store'])->middleware('checkPermission:coupon,store');
        Route::put('coupon/{id}',[couponController::class,'update'])->middleware('checkPermission:coupon,update');
        Route::delete('coupon/{id}',[couponController::class,'destroy'])->middleware('checkPermission:coupon,destroy');
        //router permission
        Route::post('permission',[permissionController::class,'store'])->middleware('checkPermission:permission,store');
        //router order
        Route::get('order/index/{recordNumber}',[orderController::class,'index']);
        Route::get('order/indexForAdmin/{recordNumber}',[orderController::class,'indexForAdmin'])->middleware('checkPermission:order,indexForAdmin');
        Route::get('order/{id}',[orderController::class,'show']);
        Route::post('order/changeStatusOrder',[orderController::class,'changeStatusOrder'])->middleware('checkPermission:order,changeStatusOrder');
        Route::delete('order/rejectOrder/{id}',[orderController::class,'rejectOrder'])->middleware('checkPermission:order,rejectOrder');
        Route::post('order/cancelOrder',[orderController::class,'cancelOrder']);
        Route::post('order/acceptOrder',[orderController::class,'acceptOrder'])->middleware('checkPermission:order,acceptOrder');
        Route::get('order/export/excel',[orderController::class,'exportExcel'])/* ->middleware('checkPermission:order,acceptOrder') */;
        Route::post('order/import/excel',[orderController::class,'importExcel'])/* ->middleware('checkPermission:order,acceptOrder') */;
        //router statistic
        Route::post('statistic/filterBySelect',[statisticController::class,'filterBySelect'])->middleware('checkPermission:statistic,filterBySelect');
        Route::post('statistic/filterByDate',[statisticController::class,'filterByDate'])->middleware('checkPermission:statistic,filterByDate');
        Route::post('statistic/profitData',[statisticController::class,'profitData'])->middleware('checkPermission:statistic,profitData');
    });

    // NOT REQUIRE LOGIN
    //router product
    Route::get('product/index/{record_number}',[productController::class,'index']);
    Route::get('product/{id}',[productController::class,'show']);
    //router category
    Route::get('category/index/{record_number}',[categoryController::class,'index']);
    Route::get('category/{id}',[categoryController::class,'show']);
    //router slider
    Route::get('slider/index/{record_number}',[sliderController::class,'index']);
    Route::get('slider/{id}',[sliderController::class,'show']);
    //router user
    Route::post('users/login',[userController::class,'login'])->name('user.login');
    Route::post('users',[userController::class,'store']);
    Route::post('users/sendCodeToEmail',[userController::class,'sendCodeToEmail']);
    Route::post('users/verifyCodeUser',[userController::class,'verifyCodeUser']);
    Route::post('users/passwordRetrieval',[userController::class,'passwordRetrieval']);
    //router role
    Route::get('role/index/{record_number}',[roleController::class,'index']);
    Route::get('role/{id}',[roleController::class,'show']);
    //router resource
    Route::get('resource/index/{record_number}',[resourceController::class,'index']);
    Route::get('resource/{id}',[resourceController::class,'show']);
    //router coupon
    Route::get('coupon/{id}',[couponController::class,'show']);
    Route::post('coupon/couponExist',[couponController::class,'couponExists']);
    //router order
    Route::post('order',[orderController::class,'store']);
    //router payment paypal
    Route::post('success-transaction', [orderController::class, 'successTransaction'])->name('successTransaction');
    Route::post('cancel-transaction', [orderController::class, 'cancelTransaction'])->name('cancelTransaction');
});

