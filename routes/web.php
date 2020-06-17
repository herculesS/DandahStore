<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth', 'prefix' => 'admin'],function () {
    Route::get('products', 'ProductController@index')->name('products');
    Route::get('categories', 'CategoryController@index')->name('categories');
    Route::get('create/category', 'CategoryController@create')->name('create.category');
});

Route::get('{path}','HomeController@index');
Route::any('/{any}', 'HomeController@index')->where('any', '.*');