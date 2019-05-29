<?php

use Illuminate\Http\Request;

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

Route::namespace('Api')->name('api.')->group(function (){
    Route::prefix('messages')->group(function ()
    {
        Route::get("list/{instance?}", 'MessagesController@index')->name('messages');
        Route::get("dev", 'MessagesController@dev')->name('all_messages');
        Route::get("{id}", 'MessagesController@show')->name('message');
        Route::post("/{instance?}", 'MessagesController@store')->name('message');
        Route::put("{id}", 'MessagesController@update')->name('message');
        Route::delete("{id}", 'MessagesController@destroy')->name('message');
    });
    Route::prefix('connections')->group(function ()
    {
        Route::get("", 'ConnectionsController@index')->name('connections');
        Route::get("dev", 'ConnectionsController@dev')->name('all_connections');
        Route::delete("{id}", 'ConnectionsController@destroy')->name('connection');
    });
});
