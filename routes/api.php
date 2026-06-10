<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProvinceController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\DistrictController;
use App\Helpers\ApiFormatter;

Route::middleware('api')->group(function () {
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::group(['middleware' => 'jwt.verify'], function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::get('refresh', [AuthController::class, 'refresh']);
        Route::get('logout', [AuthController::class, 'logout']);

        Route::prefix('province')->group(function () {
            Route::get('', [ProvinceController::class, 'index']);
            Route::post('', [ProvinceController::class, 'create']);
            Route::get('/{id}', [ProvinceController::class, 'detail']);
            Route::put('/{id}', [ProvinceController::class, 'update']);
            Route::patch('/{id}', [ProvinceController::class, 'patch']);
            Route::delete('/{id}', [ProvinceController::class, 'delete']);
        });

        Route::prefix('city')->group(function () {
            Route::get('', [CityController::class, 'index']);
            Route::get('province/{province_id}', [CityController::class, 'indexByProvince']);
            Route::post('', [CityController::class, 'create']);
            Route::get('/{id}', [CityController::class, 'detail']);
            Route::put('/{id}', [CityController::class, 'update']);
            Route::patch('/{id}', [CityController::class, 'patch']);
            Route::delete('/{id}', [CityController::class, 'delete']);
        });

        Route::prefix('district')->group(function () {
            Route::get('', [DistrictController::class, 'index']);
            Route::get('city/{city_id}', [DistrictController::class, 'indexByCity']);
            Route::post('', [DistrictController::class, 'create']);
            Route::get('/{id}', [DistrictController::class, 'detail']);
            Route::put('/{id}', [DistrictController::class, 'update']);
            Route::patch('/{id}', [DistrictController::class, 'patch']);
            Route::delete('/{id}', [DistrictController::class, 'delete']);
        });
    });

    Route::fallback(function () {
        return response()->json(ApiFormatter::createJson(404, 'Route Tidak Tersedia'), 404);
    });
});