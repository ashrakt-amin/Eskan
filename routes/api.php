<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UnitController;
use App\Http\Controllers\Api\LevelController;
use App\Http\Controllers\Api\OwnerController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ContactUsController;
use App\Http\Controllers\Api\SeekMoneyController;
use App\Http\Controllers\Api\unitsTypeController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\Auth\LoginUserController;
use App\Http\Controllers\Api\CityCenterUsersController;
use App\Http\Controllers\Api\Auth\RegisterUserController;

//start register
Route::middleware('auth:sanctum')->prefix("register")->group(function () {
    Route::post("users",  [RegisterUserController::class, "register"])->name("register.users");
});

Route::prefix("login")->group(function () {
    Route::post("users", [LoginUserController::class, "login"])->name("users.login");
});
Route::post("logout", [LogoutController::class, "logout"])->name("logout");
//end register

Route::resource('seek_money', SeekMoneyController::class);
Route::resource('projects', ProjectController::class)->only(['index', 'show']);
Route::resource('units', UnitController::class)->only(['index', 'show']);
Route::resource('units_type', unitsTypeController::class)->only(['index', 'show']);
Route::resource('reservation', ReservationController::class);
Route::resource('contact_us', ContactUsController::class);
Route::resource('CityCenter_users', CityCenterUsersController::class);
Route::resource('owners', OwnerController::class);
Route::get('levels', [LevelController::class,'index']);
Route::get('levels/{id}', [LevelController::class,'show']);
Route::get('unit/space', [UnitController::class, 'space']);




// start auth

Route::middleware('auth:sanctum')->group(function () {

    Route::resource('projects', ProjectController::class)->except(['index', 'show']);
    Route::patch('project/update/{id}', [ProjectController::class, 'update']);

    Route::resource('units', UnitController::class)->except(['index', 'show']);
    Route::post('unit/update', [UnitController::class, 'storeUp']);


    Route::resource('units_type', unitsTypeController::class)->except(['index', 'show']);
    Route::get("user", [LoginUserController::class, "show"]);

    // Route::resource('reservation', ReservationController::class)->except(['index', 'show']);
    // Route::patch('reservation/update/{id}', [ReservationController::class, 'update']);

});

// end auth
