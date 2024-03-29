<?php

use App\Http\Controllers\api\v1\PayPalController;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
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

    Route::post('success-transaction', [orderController::class, 'successTransaction'])->name('successTransaction');
    Route::post('cancel-transaction', [orderController::class, 'cancelTransaction'])->name('cancelTransaction');

    

 
