<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CenterController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\RolController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\RegionController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\GraphicController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthController::class, 'login']);

Route::name('api.')
    //->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('users', UsersController::class);
        Route::apiResource('centers', CenterController::class);
        // Route::get('graphics/users', [GraphicController::class, 'graphic']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
