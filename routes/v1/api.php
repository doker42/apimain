<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\PostController;
use Illuminate\Support\Facades\Route;




Route::get('foo', function () {

//    dd('FF');

});



Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::get( '/unauthenticated', [AuthController::class, 'unauthenticated'])->name('login');
});





Route::group([
//    'prefix' => LocalizationService::locale(),
    'middleware' => ['auth:api']
], function() {

    Route::controller(AuthController::class)->group(function () {
        Route::post('logout', 'logout');
        Route::post('refresh', 'refresh');
    });

    Route::controller(PostController::class)->group(function () {
        Route::group(['prefix' => 'posts'], function(){
            Route::get('/', 'index');
            Route::post('/', 'store');
        });
    });

});
