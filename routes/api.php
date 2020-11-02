<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/currency/get/{id}', [App\Http\Controllers\ApiController::class, 'getCurrency']);
Route::post('/products/check', [App\Http\Controllers\ApiController::class, 'productsCheck']);
Route::post('city/{city}/{country?}', [App\Http\Controllers\ApiController::class, 'city'])->name('api.city');
Route::post('country/{country}', [App\Http\Controllers\ApiController::class, 'country'])->name('api.country');
Route::post('category/{category}', [App\Http\Controllers\ApiController::class, 'category'])->name('api.category');
Route::post('brand/{brand}', [App\Http\Controllers\ApiController::class, 'brand'])->name('api.brand');
