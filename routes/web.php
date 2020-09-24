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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', 'ItemController@index');

Route::get('/item/{item}', 'ItemController@show');

Route::post('/cartitem', 'CartItemController@store');

Route::get('/cartitem', 'CartitemController@index');

Route::put('/cartitem/{cartItem}', 'CartItemController@update');
Route::delete('/cartitem/{cartItem}', 'CartItemController@destroy');
