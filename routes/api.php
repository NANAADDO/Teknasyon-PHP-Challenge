<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\PurchaseController;
use App\Http\Controllers\Api\GoogleIosController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\ReportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['namespace'=>'Api','prefix'=>'auth/user'],function(){

    Route::post('account',[LoginController::class, 'verifyAccount']);


        });

Route::group(['namespace'=>'Api','prefix'=>'device'],function(){

    Route::post('register',[RegisterController::class, 'register']);


});

Route::group(['namespace'=>'Api','prefix'=>'purchase'],function(){

    Route::post('purchase',[PurchaseController::class, 'index']);


});

Route::group(['namespace'=>'Api','prefix'=>'verification'],function(){

    Route::post('googleios',[GoogleIosController::class, 'verification']);


});

route::group(['namespace'=>'Api','prefix'=>'subscription'],function(){

    Route::post('check',[SubscriptionController::class, 'checkSubscription']);


});

oute::group(['namespace'=>'Api','prefix'=>'report'],function(){

    Route::post('day',[ReportController::class, 'daily']);
    Route::post('os',[ReportController::class, 'operatingSystem']);
    Route::post('app',[ReportController::class, 'application']);

});

