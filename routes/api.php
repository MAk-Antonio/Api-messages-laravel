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
    Route::prefix('users')->group(function ()
    {
        Route::post("auth", 'UsersController@get')->name('get_auth');
        Route::get("user/{data?}", 'UsersController@show')->name('get_user');
        Route::post("user", 'UsersController@store')->name('register_user');
        Route::put("user/{id}", 'UsersController@update')->name('update_user');
        Route::delete("user/{id}", 'UsersController@destroy')->name('delete_user');

        // DEV ROUTE TO DEBUG
        Route::get("dev", 'UsersController@dev')->name('all_users');

    });
    Route::prefix('messages')->group(function ()
    {
        Route::get("list/{instance?}", 'MessagesController@index')->name('list_messages');
        Route::get("message/{id}", 'MessagesController@show')->name('get_message');
        Route::post("message/{instance?}", 'MessagesController@store')->name('create_message');
        Route::put("message/{id}", 'MessagesController@update')->name('update_message');
        Route::delete("message/{id}", 'MessagesController@destroy')->name('delete_message');

        // DEV ROUTE TO DEBUG
        Route::get("dev", 'MessagesController@dev')->name('all_messages');
    });
    Route::prefix('connections')->group(function ()
    {
        Route::get("", 'ConnectionsController@index')->name('list_connections');
        Route::delete("connection/{id}", 'ConnectionsController@destroy')->name('show_connection');

        // DEV ROUTE TO DEBUG
        Route::get("dev", 'ConnectionsController@dev')->name('all_connections');

    });
});
