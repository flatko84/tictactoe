<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;
use App\UserToGame;
use App\Turns;
use App\Chat;
use Illuminate\Support\Facades\Auth;
use App\Library\GameSelector;

class GameController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	public function startGame($game_type, $game_id = 0) {

		$game_select = new GameSelector();
		$game = $game_select->newGame($game_type);

		$user_id = Auth::id();
		$game_mode = $game->getGameMode();
		$check_previous = UserToGame::where('user_id', $user_id)->where('status', '-1')->first();

		if (($game_mode == 1 || $game_mode == 4) && $check_previous != null && $check_previous->games->game_type == $game_type) {
			$response['creator'] = $check_previous->games->creator_user_id;
			$response['game_id'] = $check_previous->game_id;
		} else {

			Game::where('creator_user_id', $user_id)->update(['status' => '1']);
			if ($check_previous != null) {
				UserToGame::where('game_id', $check_previous->game_id)->update(['status' => '1']);
			}

			$creator = true;
			if ($game_id == 0) {
				$game = new Game;
				$game->game_type = $game_type;
				$game->game_mode = $game_mode;
				$game->creator_user_id = $user_id;
				$game->last_played_id = $user_id;
				$game->open = ($game_mode == 1) ? '0' : '1';
				$game->status = '0';
				$game->save();
				$game_id = $game->game_id;
			} elseif (Game::where('game_id', $game_id)->first()->open == '1') {

				$creator = false;
				$open = ($game_mode == 2) ? '0' : '1';

				Game::where('game_id', $game_id)
						->update(['open' => $open, 'last_played_id' => $user_id]);
			}

			if ($game_id != '0') {
				$user_to_game = new UserToGame;
				$user_to_game->game_id = $game_id;
				$user_to_game->user_id = $user_id;
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
			}

			$response = ['creator' => $creator, 'game_id' => $game_id];
		}
		return view($game_type, $response);
	}

	public function turn(Request $request) {

		$user_id = Auth::id();
		$cell = $request->message;
		$game_state = array();
		$user_game_state = array();

		$user_game = UserToGame::where('user_id', $user_id)->where('status', '-1')->first();
		$turns = Turns::where('game_id', $user_game->game_id)->get();

		$game_select = new GameSelector();
		$game = $game_select->newGame($user_game->games->game_type);

		$game_play = $game->Turn($user_id, $user_game, $turns, $cell);

		if ($game_play !== false) {
			Game::where('game_id', $user_game->game_id)
					->update(['last_played_id' => $user_id]);

			$new_turn = new Turns();
			$new_turn->user_id = $user_id;
			$new_turn->game_id = $user_game->game_id;
			$new_turn->user_game_id = $user_game->user_game_id;
			$new_turn->turn = $cell;
			$new_turn->sent = '0';
			$new_turn->save();

//			if ($game_play['end']) {
//				Game::where('game_id', $game_id)->update(['status' => '1']);
//				UserToGame::where('user_id', $user_id)->where('game_id', $game_id)->update(['status' => $game_play['end']]);
//				UserToGame::where('user_id', '!=', $user_id)->where('game_id', $game_id)->update(['status' => $game_play['other_result']]);
//			}

			return json_encode($game_play);
		}
	}

	public function chat(Request $request) {
		$user_id = Auth::id();
		$message = $request->message;
		$user_game = UserToGame::where('user_id', $user_id)->where('status', '-1')->first();

		$new_turn = new Chat();
		$new_turn->user_id = $user_id;
		$new_turn->game_id = $user_game->game_id;
		$new_turn->user_game_id = $user_game->user_game_id;
		$new_turn->message = $message;
		$new_turn->sent = '0';
		$new_turn->save();

		return json_encode($message);
	}

}
