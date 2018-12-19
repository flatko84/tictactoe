<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;
use App\UserToGame;
use Illuminate\Support\Facades\Auth;

class TictactoeController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	public function index($game_id = 0) {
		$user_id = Auth::id();
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

		$response = ['symbol' => $symbol, 'game_id' => $game_id];
		return view('tictactoe', $response);
	}

	public function turn(Request $request) {

		$user_id = Auth::id();
		$cell = $request->message;

		$allowed = ['1', '2', '4', '8', '16', '32', '64', '128', '256'];
		$win = ['73', ' 146', ' 292', ' 84', ' 273', ' 7', ' 56', ' 384'];

		$user_game = UserToGame::where('user_id', $user_id)->where('status', '-1')->first();
		$game_state = unserialize($user_game->games->state);
		$user_game_state = unserialize($user_game->state);

		if (!in_array($cell, $game_state) && $user_game->games->open == 0 && $user_game->games->last_played_id != $user_id && in_array($cell, $allowed)) {
			$game_state[] = $cell;
			$user_game_state[] = $cell;

			Game::where('game_id', $user_game->game_id)
					->update(['state' => serialize($game_state), 'last_played_id' => $user_id]);
			UserToGame::where('user_game_id', $user_game->user_game_id)
					->update(['state' => serialize($user_game_state)]);

			$symbol = ($user_game->games->creator_user_id == $user_game->user_id) ? 'X' : '0';

			$response = array(
				'symbol' => $symbol,
				'cell' => $cell
			);

			if (in_array(array_sum($user_game_state), $win)){
				$this->endGame($user_id, $user_game->game_id, 2);
			}
			elseif (count($game_state) == 9) {
				$response['end'] = $this->endGame($user_id, $user_game->game_id, 1);
			};
			return json_encode($response);
		}
	}

	protected function endGame($user_id, $game_id, $result) {
		
		$other_result = ($result > 1) ? 0 : 2 ;
		$other_result = ($result == 1) ? 1 : $other_result; 
		Game::where('game_id',$game_id)->update(['status' => '1']);
		UserToGame::where('user_id',$user_id)->where('game_id', $game_id)->update(['status' => $result]);
		UserToGame::where('user_id','!=',$user_id)->where('game_id', $game_id)->update(['status' => $other_result]);
		return $result;
	}

}

//sums to win: 73, 146, 292, 84, 273, 7, 56, 384
//BIG ToDo - validation of joining game - only when open and only when not the same user!!!
//validation of proper number request from Turn - only recognized numbers
