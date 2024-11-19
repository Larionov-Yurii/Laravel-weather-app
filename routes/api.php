<?php

use App\Http\Controllers\ForecastController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/forecast/save', [ForecastController::class, 'saveForecast']);
Route::get('/forecast/load', [ForecastController::class, 'loadForecast']);
Route::post('/forecast/fetch', [ForecastController::class, 'fetchWeather']);
