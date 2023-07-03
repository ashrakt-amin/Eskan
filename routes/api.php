<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UnitController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\SeekMoneyController;


Route::resource('seek_money',SeekMoneyController::class);
Route::resource('projects',ProjectController::class);
Route::resource('units',UnitController::class);



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
