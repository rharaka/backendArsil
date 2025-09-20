<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});
// Route::get('/dashboard', function () {
//     return view('dashboard');
// });
Route::get('/dashboard/{userID}', [App\Http\Controllers\ShipmentController::class, 'listShipments'])->name('dashboard');
Route::get('/login', function () {
    return view('login');
});
Route::get('/register', function () {
    return view('register');
});
Route::middleware('auth:sanctum')->get('/admin', function () {
    return view('admin');
});