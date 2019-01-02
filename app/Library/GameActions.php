<?php

namespace App\Library;

use App\Game;
use App\UserToGame;
use App\Turns;
use Illuminate\Support\Facades\Auth;

class GameActions {

//	Game modes:	1 = Single player only,
//					-disable joining, always closed, saveable
//		i		2 = Requires exactly two players,
//					-close on joining, cannot turn if single player, not saveable
//				3 = Multiplayer required, no max limit,
//					-close on turning, cannot turn if single player, not saveable
//				4 = Single or multiplayer allowed, saveable
//					-close on turning

	public static function startGame($game_id, $game_type, $game_mode) {
		$user_id = Auth::id();

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
		return $response;
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
