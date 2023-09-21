<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TextController;
use App\Http\Controllers\Api\UnitController;
use App\Http\Controllers\Api\BazarController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\LevelController;
use App\Http\Controllers\Api\OwnerController;
use App\Http\Controllers\Api\WalletController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ContactUsController;
use App\Http\Controllers\Api\SeekMoneyController;
use App\Http\Controllers\Api\unitsTypeController;
use App\Http\Controllers\Api\UnitsImageController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\Auth\LoginUserController;
use App\Http\Controllers\Api\CityCenterUsersController;
use App\Http\Controllers\Api\Auth\RegisterUserController;
use App\Http\Controllers\Api\BazarCustomerController;

//start register
Route::middleware('auth:sanctum')->prefix("register")->group(function () {
    Route::post("users",  [RegisterUserController::class, "register"])->name("register.users");
});

Route::prefix("login")->group(function () {
    Route::post("users", [LoginUserController::class, "login"])->name("users.login");
});
Route::post("logout", [LogoutController::class, "logout"])->name("logout");
//end register

Route::resource('text', TextController::class)->only(['index', 'show']);
Route::resource('seek_money', SeekMoneyController::class);
Route::resource('projects', ProjectController::class)->only(['index', 'show']);
Route::resource('units', UnitController::class)->only(['index', 'show']);
Route::resource('bazar', BazarController::class)->only(['index', 'show']);
Route::resource('units_type', unitsTypeController::class)->only(['index', 'show']);

Route::resource('reservation', ReservationController::class)->only(['index', 'show']);
Route::resource('contact_us', ContactUsController::class)->only(['index', 'show']);
Route::resource('wallet', WalletController::class)->only(['index', 'show']);
Route::resource('CityCenter_users', CityCenterUsersController::class)->only(['index', 'show']);
Route::resource('bazar_customer', BazarCustomerController::class)->only(['index', 'show']);
Route::resource('owners', OwnerController::class)->only(['index', 'show']);

Route::get('unit/levels', [LevelController::class, 'index']);
Route::get('levels/{id}', [LevelController::class, 'show']);
Route::resource('unit_images', UnitsImageController::class)->only(['index', 'show']);


Route::get('unit/filter/levels/{meter_price?}/{space?}', [UnitController::class, 'levels']);
Route::prefix("unit")->group(function () {
    Route::controller(UnitController::class)->group(function () {
        Route::get('/space/{meter_price?}', 'space');
        Route::get('/meter_price/{space?}', 'meterPrice');
        Route::get('/numbers/{level}/{number}', 'numbers');
    });
});

Route::prefix("bazar")->group(function () {
    Route::controller(BazarController::class)->group(function () {
        Route::get('/space/{meter_price?}', 'space');
        Route::get('/meter_price/{space?}', 'meterPrice');
    });
});

Route::resource('image', ImageController::class)->only(['index', 'show']);

// start auth

Route::middleware('auth:sanctum')->group(function () {

    Route::resource('text', TextController::class)->except(['index', 'show']);
    Route::post('text/update', [TextController::class, 'update']);
    Route::resource('projects', ProjectController::class)->except(['index', 'show']);
    Route::patch('project/update/{id}', [ProjectController::class, 'update']);
    Route::resource('units_type', unitsTypeController::class)->except(['index', 'show']);
    Route::resource('units', UnitController::class)->except(['index', 'show']);
    Route::resource('bazar', BazarController::class)->except(['index', 'show']);
    Route::post('bazar/update',[BazarController::class,'storeUp']);
    Route::prefix("units")->group(function () {
        Route::controller(UnitController::class)->group(function () {
            Route::post('/update', 'storeUp');
            Route::post('/images', 'storeImages');
            Route::delete('/delete/image/{id}', 'destroyImage');
        });
    });
    Route::resource('unit_images', UnitsImageController::class)->except(['index', 'show']);
    Route::post('unit_images/update', [UnitsImageController::class,'storeUp']);



    Route::get("user", [LoginUserController::class, "show"]);
    Route::resource('image', ImageController::class)->except(['index', 'show']);
    Route::post("update", [ImageController::class, "updateImage"]);


  
Route::resource('reservation', ReservationController::class)->except(['index', 'show']);
Route::resource('contact_us', ContactUsController::class)->except(['index', 'show']);
Route::resource('wallet', WalletController::class)->except(['index', 'show']);
Route::resource('CityCenter_users', CityCenterUsersController::class)->except(['index', 'show']);
Route::resource('bazar_customer', BazarCustomerController::class)->except(['index', 'show']);
Route::resource('owners', OwnerController::class)->except(['index', 'show']);


    Route::delete('seek_money/force_delete/{id}', [ SeekMoneyController::class,'forceDelete']);
    Route::delete('reservation/force_delete/{id}', [ ReservationController::class,'forceDelete']);
    Route::delete('contact_us/force_delete/{id}', [ ContactUsController::class,'forceDelete']);
    Route::delete('CityCenter_users/force_delete/{id}', [ CityCenterUsersController::class,'forceDelete']);
    Route::delete('owners/force_delete/{id}', [ OwnerController::class,'forceDelete']);

});

// end auth
