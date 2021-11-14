<?php

use App\Http\Controllers\UserController;
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

//todo clean up routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/users/country/{countryCode}', [UserController::class, 'getUsersByCountryCode']);
Route::get('/users/{user}/delete', [UserController::class, 'delete']);
