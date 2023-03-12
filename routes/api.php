<?php

use App\Http\Controllers\v1\AuthController;
use App\Http\Controllers\v1\BlockController;
use App\Http\Controllers\v1\FlatController;
use App\Http\Controllers\v1\ProjectController;
use App\Http\Controllers\v1\SectionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'v1'], function () {
    Route::post('login', [AuthController::class, 'login']);

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('projects/{project}/import', [ProjectController::class, 'import']);
        Route::get('projects/{project}/board', [ProjectController::class, 'board']);
        Route::apiResource('projects', ProjectController::class);
        Route::group(['prefix' => 'projects/{project}'], function () {
            Route::apiResource('blocks', BlockController::class)->except('index', 'show');
            Route::group(['prefix' => 'blocks/{block}'], function () {
                Route::apiResource('flats', FlatController::class)->except('index');
            });
        });
    });

});
