<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;
use App\UserToGame;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$user_id = Auth::id();
		$check_previous = UserToGame::where('user_id', $user_id)->where('status', '-1')->first();


		if ($check_previous != null) {
			Game::where('game_id', $check_previous->game_id)->update(['status' => '1']);
			UserToGame::where('game_id', $check_previous->game_id)->update(['status' => '1']);
		}
		return view('home');
	}

}
