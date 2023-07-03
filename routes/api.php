<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UnitController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\SeekMoneyController;
use App\Http\Controllers\Api\unitsTypeController;
use App\Http\Controllers\Api\auth\LogoutController;
use App\Http\Controllers\Api\auth\LoginUserController;
use App\Http\Controllers\Api\auth\RegisterUserController;


//start register
Route::middleware('auth:sanctum')->prefix("register")->group(function () {
    Route::post("users",  [RegisterUserController::class, "register"])->name("register.users");
});

Route::prefix("login")->group(function () {
    Route::post("users", [LoginUserController::class, "login"])->name("users.login");
});
Route::post("logout", [LogoutController::class, "logout"])->name("logout");
//end register



Route::middleware('auth:sanctum')->group(function () {

    Route::resource('seek_money', SeekMoneyController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('units', UnitController::class);
    Route::resource('units_type', unitsTypeController::class);
});
