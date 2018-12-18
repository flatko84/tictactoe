<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;

class TictactoeController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	public function index() {


		$game = new Game(				);
		return view('tictactoe');
	}

	public function turn(Request $request) {

		$cell = $request->message;
		$symbol = 'X';

		$response = array(
			'symbol' => $symbol,
			'cell' => $cell
		);

		return json_encode($response);
	}

}
//sums to win: 73, 146, 292, 84, 273, 7, 56, 384