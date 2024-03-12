<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\TextController;
use App\Http\Controllers\Api\UnitController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\BazarController;
use App\Http\Controllers\Api\BlockController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\LevelController;
use App\Http\Controllers\Api\OwnerController;
use App\Http\Controllers\Api\WalletController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ContactUsController;
use App\Http\Controllers\Api\FormsellsController;
use App\Http\Controllers\Api\ParkUsersController;
use App\Http\Controllers\Api\SeekMoneyController;
use App\Http\Controllers\Api\unitsTypeController;
use App\Http\Controllers\Api\UnitsImageController;
use App\Http\Controllers\Api\UserWalletController;
use App\Http\Controllers\Api\WalletUnitController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\UpdateController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\SellProjectController;
use App\Http\Controllers\Api\BazarCustomerController;
use App\Http\Controllers\Api\SellerProfileController;
use App\Http\Controllers\Api\Auth\LoginUserController;
use App\Http\Controllers\Api\CityCenterUsersController;
use App\Http\Controllers\Api\CustomerQuestionController;
use App\Http\Controllers\Api\Auth\RegisterUserController;
use App\Http\Controllers\Api\LinkController;
use App\Http\Controllers\Api\RealEstateProjectController;

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
Route::resource('wallet_units', WalletUnitController::class)->only(['index', 'show']);
Route::resource('units', UnitController::class)->only(['index', 'show']);
Route::resource('unit_images', UnitsImageController::class)->only(['index', 'show']);
Route::resource('bazar', BazarController::class)->only(['index', 'show']);
Route::resource('block', BlockController::class)->only(['index', 'show']);
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
Route::resource('user/wallet_unit', UserWalletController::class)->only('store');
Route::resource('park_user', ParkUsersController::class)->only('store');

Route::get('unit/levels', [LevelController::class, 'index']);
Route::get('levels/{id}', [LevelController::class, 'show']);
Route::prefix("unit")->group(function () {
    Route::controller(UnitController::class)->group(function () {
        Route::get('/space', 'space');
        Route::get('/meter_price', 'meterPrice');
        Route::get('/level', 'levels');
        Route::get('/numbers/{level}/{number}', 'numbers');

        Route::get('/block/space/{block_id}/{meter_price}', 'block_space');
        Route::get('/block/meter_price/{block_id}/{space}', 'block_meter_price');
        Route::get('/block/level', 'block_levels');

        // Route::get('/block/level/{block_id}/{space}/{meter_price}', 'block_levels');
        Route::get('/block/number/{block_id}/{number}', 'block_number');
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

Route::prefix("user")->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/all', 'get_sells');
        Route::get('/admins', 'get_admins');
    });
});
Route::resource('sells/project', SellProjectController::class)->only(['index', 'show']);
Route::resource('sells/project/client', FormsellsController::class)->only(['store']);
Route::get('sells/site', [SellerProfileController::class, 'sells_site']);

Route::resource('link', LinkController::class)->only(['index', 'show']);




// Route::post('/post/comment', [CommentController::class, 'store'])
//     ->middleware(['auth:sanctum', 'optional-auth']);
//     ->name('comments.store');

// start auth

Route::middleware('auth:sanctum')->group(function () {
    Route::post("logout", [LogoutController::class, "logout"])->name("logout");

    Route::resource("users", UserController::class);


    Route::resource('text', TextController::class)->except(['index', 'show']);
    Route::post('text/update', [TextController::class, 'update']);
    Route::resource('projects', ProjectController::class)->except(['index', 'show']);
    Route::resource('block', BlockController::class)->except(['index', 'show']);
    Route::post('block/update/{id}', [BlockController::class, 'update']);
    Route::resource('projects-wallet', RealEstateProjectController::class)->except(['index', 'show']);
    Route::resource('wallet_units', WalletUnitController::class)->except(['index', 'show']);
    Route::post('wallet_units/update/{id}', [WalletUnitController::class, 'unit_update']);

    Route::prefix("wallet")->group(function () {
        Route::controller(RealEstateProjectController::class)->group(function () {
            Route::post('/file', 'addFile');
            Route::post('/project/update/{id}', 'updateProject');
            Route::delete('/file/delete/{id}', 'destroyFile');
        });
    });

    Route::post('project/update/{id}', [ProjectController::class, 'updateImage']);
    Route::post('update/project/{id}', [ProjectController::class, 'update']);
    Route::delete('project/delete/{id}', [ProjectController::class, 'deleteImage']);

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
            Route::post('commercial', 'storeCommercial');
            Route::post('commercial/update', 'commercialUpdate');
        });
    });
    Route::resource('unit_images', UnitsImageController::class)->except(['index', 'show']);
    Route::post('unit_images/update', [UnitsImageController::class, 'storeUp']);



    //user 
    Route::get("user", [LoginUserController::class, "show"]);
    Route::put("user/update/{id}", [UpdateController::class, "update"]);
    Route::post("user/image/update", [UpdateController::class, "updateImage"]);


    Route::resource('image', ImageController::class)->except(['index', 'show']);
    Route::post("update", [ImageController::class, "updateImage"]);



    Route::resource('reservation', ReservationController::class)->except('store');
    Route::resource('contact_us', ContactUsController::class)->except('store');
    Route::resource('wallet', WalletController::class)->except('store');
    Route::resource('CityCenter_users', CityCenterUsersController::class)->except('store');
    Route::resource('bazar_customer', BazarCustomerController::class)->except('store');
    Route::resource('jobs', JobController::class)->except(['store']);
    Route::resource('owners', OwnerController::class)->except('store');
    Route::resource('user/wallet_unit', UserWalletController::class)->except('store');
    Route::resource('park_user', ParkUsersController::class)->except('store');
    Route::resource('customer/question', CustomerQuestionController::class);


    Route::delete('seek_money/force_delete/{id}', [SeekMoneyController::class, 'forceDelete']);
    Route::delete('reservation/force_delete/{id}', [ReservationController::class, 'forceDelete']);
    Route::delete('contact_us/force_delete/{id}', [ContactUsController::class, 'forceDelete']);
    Route::delete('CityCenter_users/force_delete/{id}', [CityCenterUsersController::class, 'forceDelete']);
    Route::delete('owners/force_delete/{id}', [OwnerController::class, 'forceDelete']);
    Route::delete('user/wallet_unit/force_delete/{id}', [UserWalletController::class, 'forceDelete']);

    Route::get('park_user/restore/{id}', [ParkUsersController::class, 'restore']);
    Route::delete('park_user/force_delete/{id}', [ParkUsersController::class, 'forceDelete']);



    Route::resource('post', PostController::class)->except(['index', 'show']);
    Route::post('post/update/{id}', [PostController::class, 'postUpdate']);


    //sells project 
    Route::prefix("sells")->group(function () {
        Route::resource('/project', SellProjectController::class)->except(['index', 'show']);
        Route::post('/project/update', [SellProjectController::class, 'update_sellProject']);

        Route::controller(SellerProfileController::class)->group(function () {
            Route::get('/profile/dash/{id?}', 'show_user');
            Route::get('/profile/project/dash/{id}', 'show_project');
            Route::get('/clients', 'sells_project_client');
            Route::get('/sells', 'sells_project_sells');
            Route::get('/profiles', 'index');
            //sells admin
            Route::get('/admin/prjects', 'sells_project');
        });
    });

    Route::post('sells/client', [FormsellsController::class, "update_status"]);

    Route::resource('link', LinkController::class)->except(['index', 'show']);
});

// end auth
