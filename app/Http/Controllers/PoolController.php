<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;
use App\UserToGame;
use App\Turns;
use Illuminate\Support\Facades\Auth;
use App\Library\GameActions;

class PoolController extends Controller
{
    public function __construct() {
		$this->middleware('auth');
	}

	public function index($game_id = 0) {

		$data = GameActions::startGame($game_id, 'pool', 2);

		$response['game_id'] = $data['game_id'];
		$response['symbol'] = ($data['creator'] === true) ? 'white' : 'black';
		$response['other'] = ($data['creator'] === true) ? 'black' : 'white';

		return view('pool', $response);
	}
	
	public function turn(Request $request) {
		
		$user_id = Auth::id();
		$cell = $request->message;
		$game_state = array();
		$user_game_state = array();

		$user_game = UserToGame::where('user_id', $user_id)->where('status', '-1')->first();
		$turns = Turns::where('game_id', $user_game->game_id)->get();

		foreach ($turns as $turn) {
			if ($turn->turn != 'start') {
				$game_state[] = $turn->turn;
				if ($turn->user_id == $user_id) {
					$user_game_state[] = $turn->turn;
				}
			}
		}

		if (!in_array($cell, $game_state) && $user_game->games->open == 0 && $user_game->games->last_played_id != $user_id) {
			
			$game_state[] = $cell;
			$user_game_state[] = $cell;

			Game::where('game_id', $user_game->game_id)
					->update(['last_played_id' => $user_id]);

			$new_turn = new Turns();
			$new_turn->user_id = $user_id;
			$new_turn->game_id = $user_game->game_id;
			$new_turn->user_game_id = $user_game->user_game_id;
			$new_turn->turn = $cell;
			$new_turn->sent = '0';
			$new_turn->save();

			$symbol = ($user_game->games->creator_user_id == $user_game->user_id) ? 'black' : 'white';

			$response = array(
				'symbol' => $symbol,
				'cell' => $cell
			);

			if ($this->calculateWin($user_game_state) == 1) {
				$response['end'] = GameActions::endGame($user_id, $user_game->game_id, 2);
			} elseif (count($game_state) == 9) {
				$response['end'] = GameActions::endGame($user_id, $user_game->game_id, 1);
			};
			return json_encode($response);
		}
	}
	
	protected function calculateWin($state){
		return 0;
	}
}
