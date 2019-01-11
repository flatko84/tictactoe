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
Route::get('/game', 'GameController@startGame');
Route::get('/game/{game_type}/{game_id?}', 'GameController@startGame')->name('game');
Route::post('/game/turn', 'GameController@turn');
Route::post('/game/chat', 'GameController@chat');

Route::get('/update/{game_id}', 'UpdateController@index');
Route::get('/chat/{game_id}', 'UpdateController@chat');
Route::get('/opengames', 'UpdateController@getOpenGames');
