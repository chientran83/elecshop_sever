<?php

use App\Http\Controllers\api\v1\categoryController;
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
     //router product
     Route::prefix('product')->group(function(){
     Route::get('index/{record_number}',[productController::class,'index']);
     });
     Route::resource('product',productController::class)->except(['edit','create','index']);
     //router category
     Route::get('category/index/{record_number}',[categoryController::class,'index']);
     Route::resource('category',categoryController::class)->except(['edit','create'])->except(['index']);
     //router slider
     Route::get('slider/index/{record_number}',[sliderController::class,'index'])->middleware('checkPermission:slider,index');
     Route::resource('slider',sliderController::class)->except(['edit','create','index']);
     //router user
     Route::get('users/index/{record_number}',[userController::class,'index']);
     Route::get('users/user_login',[userController::class,'user_login']);
     Route::post('users/login',[userController::class,'login'])->name('user.login');
     Route::post('users/logout',[userController::class,'logout'])->name('user.logout');
     Route::post('users/refresh_token',[userController::class,'refresh_token'])->name('user.refresh_token');
     Route::resource('users',userController::class)->except(['edit','create','index']);
     //router role
     Route::get('role/index/{record_number}',[roleController::class,'index']);
     Route::post('role',[roleController::class,'store']);
     Route::delete('role/{id}',[roleController::class,'destroy']);
     Route::get('role/{id}',[roleController::class,'show']);
     Route::put('role/{id}',[roleController::class,'update']);
     //router resource
     Route::get('resource/index/{record_number}',[resourceController::class,'index']);
     Route::post('resource',[resourceController::class,'store']);
     Route::get('resource/{id}',[resourceController::class,'show']);
     Route::put('resource/{id}',[resourceController::class,'update']);
     Route::delete('resource/{id}',[resourceController::class,'delete']);
     //router permission
     Route::post('permission',[permissionController::class,'store']);
 });

