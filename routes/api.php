<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SeriesController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['middleware' => 'api'], function ($routes) {
    Route::post('/login',[UserController::class,'login']);
    Route::post('/register',[UserController::class,'register']);
    Route::get('/logout',[UserController::class,'logout']);

    Route::get('/webtoons',[SeriesController::class,'showSeries']);
    Route::get('/webtoons/{id}',[SeriesController::class,'showParticularSeries']);
    Route::post('/webtoons/add',[SeriesController::class,'addSeries']);
    Route::delete('/webtoons/remove/{id}',[SeriesController::class,'deleteSeries']);

    // Rout::get('/webtoons',[]);
    
});


