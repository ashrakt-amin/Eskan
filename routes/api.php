<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\TextController;
use App\Http\Controllers\Api\UnitController;
use App\Http\Controllers\Api\BazarController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\LevelController;
use App\Http\Controllers\Api\OwnerController;
use App\Http\Controllers\Api\WalletController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\RealEstateProjectController;
use App\Http\Controllers\Api\ContactUsController;
use App\Http\Controllers\Api\SeekMoneyController;
use App\Http\Controllers\Api\unitsTypeController;
use App\Http\Controllers\Api\UnitsImageController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\BazarCustomerController;
use App\Http\Controllers\Api\Auth\LoginUserController;
use App\Http\Controllers\Api\CityCenterUsersController;
use App\Http\Controllers\Api\Auth\RegisterUserController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CommentController;



//start register
Route::middleware('auth:sanctum')->prefix("register")->group(function () {
    Route::post("users",  [RegisterUserController::class, "register"])->name("register.users");

});

Route::prefix("login")->group(function () {
    Route::post("users", [LoginUserController::class, "login"])->name("users.login");
});
//end register

Route::resource('text', TextController::class)->only(['index', 'show']);

// projects 
Route::resource('projects', ProjectController::class)->only(['index', 'show']);
Route::resource('projects-wallet', RealEstateProjectController::class)->only(['index', 'show']);
Route::resource('units', UnitController::class)->only(['index', 'show']);
Route::resource('unit_images', UnitsImageController::class)->only(['index', 'show']);
Route::resource('bazar', BazarController::class)->only(['index', 'show']);
Route::prefix("bazar")->group(function () {
    Route::controller(BazarController::class)->group(function () {
        Route::get('/space/{meter_price?}', 'space');
        Route::get('/meter_price/{space?}', 'meterPrice');
        Route::get('/unique/numbers', 'numbers');
        Route::get('/unique/revenue', 'revenue');
    });
});
Route::resource('units_type', unitsTypeController::class)->only(['index', 'show']);



//customer
Route::resource('reservation', ReservationController::class)->only('store');
Route::resource('contact_us', ContactUsController::class)->only('store');
Route::resource('wallet', WalletController::class)->only('store');
Route::resource('CityCenter_users', CityCenterUsersController::class)->only('store');
Route::resource('bazar_customer', BazarCustomerController::class)->only('store');
Route::resource('jobs', JobController::class)->only('store');
Route::resource('owners', OwnerController::class)->only('store');
Route::resource('seek_money', SeekMoneyController::class)->only('store');




Route::get('unit/levels', [LevelController::class, 'index']);
Route::get('levels/{id}', [LevelController::class, 'show']);
Route::get('unit/filter/levels/{meter_price?}/{space?}', [UnitController::class, 'levels']);
Route::prefix("unit")->group(function () {
    Route::controller(UnitController::class)->group(function () {
        Route::get('/space/{meter_price?}', 'space');
        Route::get('/meter_price/{space?}', 'meterPrice');
        Route::get('/numbers/{level}/{number}', 'numbers');
    });
});


Route::resource('image', ImageController::class)->only(['index', 'show']);
Route::resource('post', PostController::class)->only(['index', 'show']);
Route::resource('comment', CommentController::class);

Route::prefix("comment")->group(function () {
    Route::controller(CommentController::class)->group(function () {
        Route::post('/store', 'store');
    // Route::put('/update', 'update');
    });
});

// Route::post('/post/comment', [CommentController::class, 'store'])
//     ->middleware(['auth:sanctum', 'optional-auth']);
//     ->name('comments.store');

// start auth

Route::middleware('auth:sanctum')->group(function () {
    Route::post("logout", [LogoutController::class, "logout"])->name("logout");
    Route::resource("user/admins", UserController::class);
    Route::resource('text', TextController::class)->except(['index', 'show']);
    Route::post('text/update', [TextController::class, 'update']);
    Route::resource('projects', ProjectController::class)->except(['index', 'show']);
    Route::resource('projects-wallet', RealEstateProjectController::class)->except(['index', 'show']);
    Route::prefix("wallet")->group(function () {
        Route::controller(RealEstateProjectController::class)->group(function () {
            Route::post('/file', 'addFile');
            Route::post('/project/update/{id}', 'updateProject');
            Route::delete('/file/delete/{id}', 'destroyFile');
        });
    });
    Route::patch('project/update/{id}', [ProjectController::class, 'update']);
    Route::resource('units_type', unitsTypeController::class)->except(['index', 'show']);
    Route::resource('units', UnitController::class)->except(['index', 'show']);
    Route::resource('bazar', BazarController::class)->except(['index', 'show']);
    Route::post('bazar/update', [BazarController::class, 'storeUp']);
    Route::resource('seek_money', SeekMoneyController::class)->except('store');
    Route::prefix("units")->group(function () {
        Route::controller(UnitController::class)->group(function () {
            Route::post('/update', 'storeUp');
            Route::post('/images', 'storeImages');
            Route::delete('/delete/image/{id}', 'destroyImage');
        });
    });
    Route::resource('unit_images', UnitsImageController::class)->except(['index', 'show']);
    Route::post('unit_images/update', [UnitsImageController::class, 'storeUp']);



    Route::get("user", [LoginUserController::class, "show"]);
    Route::resource('image', ImageController::class)->except(['index', 'show']);
    Route::post("update", [ImageController::class, "updateImage"]);



    Route::resource('reservation', ReservationController::class)->except('store');
    Route::resource('contact_us', ContactUsController::class)->except('store');
    Route::resource('wallet', WalletController::class)->except('store');
    Route::resource('CityCenter_users', CityCenterUsersController::class)->except('store');
    Route::resource('bazar_customer', BazarCustomerController::class)->except('store');
    Route::resource('jobs', JobController::class)->except(['store']);
    Route::resource('owners', OwnerController::class)->except('store');


    Route::delete('seek_money/force_delete/{id}', [SeekMoneyController::class, 'forceDelete']);
    Route::delete('reservation/force_delete/{id}', [ReservationController::class, 'forceDelete']);
    Route::delete('contact_us/force_delete/{id}', [ContactUsController::class, 'forceDelete']);
    Route::delete('CityCenter_users/force_delete/{id}', [CityCenterUsersController::class, 'forceDelete']);
    Route::delete('owners/force_delete/{id}', [OwnerController::class, 'forceDelete']);

    Route::resource('post', PostController::class)->except(['index', 'show']);
    Route::post('post/update/{id}',[PostController::class ,'postUpdate']);


});

// end auth
