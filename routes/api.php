<?php

use App\Http\Controllers\API\CategoryController;
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

Route::group(['prefix' => 'categories'], function () {
    Route::get('/','API\CategoryController@index');
    Route::get('/{id}','API\CategoryController@show');
    Route::patch('/update/{id}','API\CategoryController@update');
    Route::put('/create/','API\CategoryController@store');
    Route::delete('/delete/{id}','API\CategoryController@destroy');
});

Route::group(['prefix' => 'products'], function () {
    Route::get('/','API\ProductController@index');
    Route::get('/{id}','API\ProductController@show');
    Route::patch('/update/{id}','API\ProductController@update');
    Route::put('/create/','API\ProductController@store');
    Route::delete('/delete/{id}','API\ProductController@destroy');
});
