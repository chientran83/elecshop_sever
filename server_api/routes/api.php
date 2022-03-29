<?php

use App\Http\Controllers\api\v1\categoryController;
use App\Http\Controllers\api\v1\permissionController;
use App\Http\Controllers\api\v1\productController;
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

 Route::prefix('v1')->group(function(){
     //router product
     Route::prefix('product')->group(function(){
         Route::get('pagination',[productController::class,'pagination']);
     });
     Route::resource('product',productController::class)->except(['edit','create']);
     //router category
     Route::get('category/paginate',[categoryController::class,'paginate'])->middleware('can:admin'); /* ->middleware('allowedDomains') */
     Route::resource('category',categoryController::class)->except(['edit','create']);
     //router slider
     Route::resource('slider',sliderController::class)->except(['edit','create']);
     //router user
     Route::post('users/login',[userController::class,'login'])->name('user.login');
     Route::get('users/logout',[userController::class,'logout'])->name('user.logout');
     Route::get('users/delete_token',[userController::class,'delete_token'])->name('user.delete_token');
     Route::resource('users',userController::class)->except(['edit','create']);
     //router role
     Route::post('role',[roleController::class,'store']);
     //router permission
     Route::post('permission',[permissionController::class,'store']);
 });

