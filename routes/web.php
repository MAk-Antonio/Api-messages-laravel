<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('docs');
});

Route::prefix('docs')->group(function ()
{
    Route::get('/',function (){
        return view('doc');
    });
});
Route::prefix('/model')->group(function ()
{
    Route::get('user',function (){
        return view('models.users');
    });
    Route::get('messages',function (){
        return view('models.messages');
    });
    Route::get('connections',function (){
        return view('models.connections');
    });
});
