<?php

use App\Http\Controllers\Api\V1\ArticleController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CurrencyController;
use App\Http\Controllers\Api\V1\PostController;
use App\Http\Controllers\Api\V1\ProfileController;
use Illuminate\Support\Facades\Route;


//use Elasticsearch;




Route::get('foo', function () {

    $source = \App\Currencies\CurrencyManager::getSource();

    dump($source->getId());
//    $rates = $source->rates();
//    dump($rates);




//    $stats = Elasticsearch::nodes()->stats();



//    $arr = [1,3,4,5];
//
//
////    $i = 10;
//
//    for ($i = 0; $i<10;  $i++) {
////        dump($i);
//        $rand = $arr[array_rand($arr,1)];
//        echo($rand . ' ' . PHP_EOL);
//    }



});



Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::get( '/unauthenticated', [AuthController::class, 'unauthenticated'])->name('login');
});


Route::controller(ArticleController::class)->group(function () {
    Route::group(['prefix' => 'articles'], function(){
        Route::get('/', 'index');
        Route::post('/', 'store');

        Route::get('/search', 'search');
    });
});


Route::controller(CurrencyController::class)->group(function () {
    Route::group(['prefix' => 'currencies'], function(){
        Route::get('/', 'rates');
        Route::get('/{currency_id}', 'rate');
    });
});


Route::controller(PostController::class)->group(function () {
    Route::group(['prefix' => 'posts'], function(){
        Route::get('/', 'index');
        Route::post('/', 'store');
    });
});




Route::group([
//    'prefix' => LocalizationService::locale(),
    'middleware' => ['auth:api']
], function() {

    Route::controller(AuthController::class)->group(function () {
        Route::post('logout', 'logout');
        Route::post('refresh', 'refresh');
    });

//    Route::controller(PostController::class)->group(function () {
//        Route::group(['prefix' => 'posts'], function(){
//            Route::get('/', 'index');
//            Route::post('/', 'store');
//        });
//    });

    Route::controller(ProfileController::class)->group(function () {
        Route::post('forgot-password', 'forgotPassword')->name('password.forgot');
        Route::post('reset-password', 'resetPassword')->name('password.reset');
        Route::post('set-password', 'setPassword')->name('password.set');
        Route::get('set-email', 'setEmail');

        Route::group(['prefix' => 'profile'], function(){
            Route::put('/password', 'updatePassword');
            Route::get('/', 'show');

            Route::delete('/avatar', 'deleteAvatar');
            Route::post('/avatar', 'updateAvatar');
            Route::get('/avatar', 'showAvatar');
        });
    });

});
