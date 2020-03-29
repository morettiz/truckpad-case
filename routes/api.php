<?php

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

Route::prefix('arrival')->group(function (): void {
    Route::get('/{id}', 'ArrivalController@get');
    Route::get('/', 'ArrivalController@index');
    Route::post('/', 'ArrivalController@store');
    Route::put('/{id}', 'ArrivalController@update');
});

Route::prefix('trucker')->group(function (): void {
    Route::get('/loaded', 'TruckerController@getLoadedTrucks');
    Route::get('/unloaded', 'TruckerController@getUnloadedTrucks');
    Route::get('/truck-owners', 'TruckerController@getTruckOwners');
    Route::get('/routes', 'TruckerController@getRoutesGroupedByTruckType');
});
