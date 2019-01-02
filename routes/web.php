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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/tictactoe', 'TictactoeController@index')->name('tictactoe');
Route::get('/tictactoe/{game_id}','TictactoeController@index');
Route::get('/pool', 'PoolController@index')->name('tictactoe');
Route::get('/pool/{game_id}','PoolController@index');
Route::post('/tictactoe/turn','TictactoeController@turn');
Route::post('/pool/turn','PoolController@turn');


Route::get('/update/{game_id}','UpdateController@index');
Route::get('/opengames','UpdateController@getOpenGames');
