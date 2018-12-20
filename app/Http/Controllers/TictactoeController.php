<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;
use App\UserToGame;
use App\Turns;
use Illuminate\Support\Facades\Auth;

class TictactoeController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	public function index($game_id = 0) {

		$user_id = Auth::id();

		//UserToGame::where('user_id')
		$symbol = '0';
		if ($game_id == 0) {
			$game = new Game;
			$game->creator_user_id = $user_id;
			$game->last_played_id = $user_id;
			$game->open = '1';
			$game->state = serialize(array());
			$game->status = '0';
			$game->save();
			$game_id = $game->game_id;
		} else {
			$symbol = 'X';
			Game::where('game_id', $game_id)
					->update(['open' => '0', 'last_played_id' => $user_id]);
		}

		$user_to_game = new UserToGame;
		$user_to_game->game_id = $game_id;
		$user_to_game->user_id = $user_id;
		$user_to_game->state = serialize(array());
		$user_to_game->status = '-1';
		$user_to_game->save();
		
		$user_game_id = $user_to_game->user_game_id;
		

		$turn = new Turns;
		$turn->game_id = $game_id;
		$turn->user_id = $user_id;
		$turn->user_game_id = $user_game_id;
		$turn->turn = 'start';
		$turn->sent = '0';
		$turn->save();

		$response = ['symbol' => $symbol, 'game_id' => $game_id];
		return view('tictactoe', $response);
	}

	public function turn(Request $request) {

		$user_id = Auth::id();
		$cell = $request->message;
		$game_state = array();
		$user_game_state = array();
		
		$user_game = UserToGame::where('user_id', $user_id)->where('status', '-1')->first();
		$turns = Turns::where('game_id',$user_game->game_id)->get();
		
		foreach ($turns as $turn){
			$game_state[] = $turn->turn;
			if ($turn->user_id == $user_id) {
				$user_game_state[] = $turn->turn;
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
			
			$symbol = ($user_game->games->creator_user_id == $user_game->user_id) ? 'X' : '0';

			$response = array(
				'symbol' => $symbol,
				'cell' => $cell
			);

			if ($this->calculateWin($user_game_state) == 1) {
				$response['end'] = $this->endGame($user_id, $user_game->game_id, 2);
			} elseif (count($game_state) == 9) {
				$response['end'] = $this->endGame($user_id, $user_game->game_id, 1);
			};
			return json_encode($response);
		}
	}

	protected function endGame($user_id, $game_id, $result) {

		$other_result = ($result > 1) ? 0 : 2;
		$other_result = ($result == 1) ? 1 : $other_result;
		Game::where('game_id', $game_id)->update(['status' => '1']);
		UserToGame::where('user_id', $user_id)->where('game_id', $game_id)->update(['status' => $result]);
		UserToGame::where('user_id', '!=', $user_id)->where('game_id', $game_id)->update(['status' => $other_result]);
		return $result;
	}

	protected function calculateWin($fields) {
		$win_combinations = [['1', '2', '3'], ['4', '5', '6'], ['7', '8', '9'], ['1', '4', '7'], ['2', '5', '8'], ['3', '6', '9'], ['1', '5', '9'], ['3', '5', '7']];
		$result = 0;

		foreach ($win_combinations as $win_combination) {
			$occurence = 0;
			foreach ($win_combination as $win_field) {
				if (in_array($win_field, $fields)) {
					$occurence++;
				}
			}
			if ($occurence == 3) {
				$result = 1;
			}
		}
		return $result;
	}

}

//BIG ToDo - validation of joining game - only when open and only when not the same user!!!
//validation of proper number request from Turn - only recognized numbers
