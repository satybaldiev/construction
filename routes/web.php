<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', [AuthController::class,'login'])->name('login');
Route::post('/login', [AuthController::class,'postLogin']);
Route::get('/forgot-password', [AuthController::class,'login'])->name('forgot-password');

Route::group(['middleware' => 'auth'],function(){
    Route::get('/', [DashboardController::class,'index']);

});
