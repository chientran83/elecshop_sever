<?php

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
        /* if (! Gate::allows('update-article')) {
            abort(403);
        } */
        return view('welcome');
    })/* ->middleware('can:admin') */ ;

 
