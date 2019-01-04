<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;
use App\UserToGame;
use App\Turns;
use Illuminate\Support\Facades\Auth;
use App\Library\GameSelector;

class GameController extends Controller {

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
		$game_mode = $game->getGameMode();

		foreach ($turns as $turn) {
			if ($turn->turn != 'start') {
				$game_state[] = $turn->turn;
				if ($turn->user_id == $user_id) {
					$user_game_state[] = $turn->turn;
				}
			}
		}

		if (!in_array($cell, $game_state) && $user_game->games->open == 0 && $user_game->games->last_played_id != $user_id && (int) $cell >= 1 && (int) $cell <= 9) {
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

			$response = array(
				'cell' => $cell
			);

			if ($game->calculateWin($user_game_state) == 1) {
				$response['end'] = $this->endGame($user_id, $user_game->game_id, 2);
			} elseif (count($game_state) == 9) {
				$response['end'] = $this->endGame($user_id, $user_game->game_id, 1);
			}
			return json_encode($response);
		}
	}

	public static function endGame($user_id, $game_id, $result) {
		$other_result = ($result > 1) ? 0 : 2;
		$other_result = ($result == 1) ? 1 : $other_result;
		Game::where('game_id', $game_id)->update(['status' => '1']);
		UserToGame::where('user_id', $user_id)->where('game_id', $game_id)->update(['status' => $result]);
		UserToGame::where('user_id', '!=', $user_id)->where('game_id', $game_id)->update(['status' => $other_result]);
		return $result;
	}

}
