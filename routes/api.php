<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShipmentUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StripePaymentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/insert-shipment', 'App\Http\Controllers\ShipmentController@insertShipment');
Route::get('/list-shipments', 'App\Http\Controllers\ShipmentController@listShipments');
Route::post('/get-shipment', 'App\Http\Controllers\ShipmentController@getShipment');
Route::post('/set-shipments', 'App\Http\Controllers\ShipmentController@updateShipment');
Route::post('/update-contacts', 'App\Http\Controllers\ShipmentController@updateShipmentContacts');
Route::post('/shipment-payed', 'App\Http\Controllers\ShipmentController@payedShipment');
Route::post('/cites-by-code', 'App\Http\Controllers\ShipmentController@getCitiesByCode');

Route::post('/register', 'App\Http\Controllers\AuthController@register');
Route::post('/login', 'App\Http\Controllers\AuthController@login');
Route::post('/admin-register', 'App\Http\Controllers\AuthController@adminRegister');
Route::post('/admin-login', 'App\Http\Controllers\AuthController@adminLogin');
Route::middleware('auth:sanctum')->post('/logout', 'App\Http\Controllers\AuthController@logout');
Route::post('/logout-user', 'App\Http\Controllers\UserController@logout');
Route::post('/get-user', 'App\Http\Controllers\UserController@getUser');

Route::middleware('auth:sanctum')->group(function() {

    Route::post('/insert-user', 'App\Http\Controllers\UserController@insertUser');
    Route::get('/list-users', 'App\Http\Controllers\UserController@listUsers');
    // Route::post('/get-user', 'App\Http\Controllers\UserController@getUser');
    Route::post('/set-users', 'App\Http\Controllers\UserController@updateUser');
    Route::post('/user-by-token', 'App\Http\Controllers\UserController@getUserByToken');

    Route::post('/get-shipment-user', 'App\Http\Controllers\ShipmentUserController@getShipmentUser');
    Route::post('/shipments-by-user', 'App\Http\Controllers\ShipmentUserController@listShipmentsUser');

});

Route::post('/get-prices', 'App\Http\Controllers\PriceController@getPrices');

Route::get('/stripe', 'App\Http\Controllers\StripePaymentController@stripe');
Route::post('/stripe-checkout', 'App\Http\Controllers\StripePaymentController@stripePost');
Route::post('/create-checkout', 'App\Http\Controllers\StripePaymentController@createCheckout');


