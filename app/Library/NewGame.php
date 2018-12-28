<?php

namespace App\Library;

use App\Game;
use App\UserToGame;
use App\Turns;
use Illuminate\Support\Facades\Auth;

class NewGame {

	public function index($game_id = 0) {
		$user_id = Auth::id();

		$check_previous = UserToGame::where('user_id', $user_id)->where('status', '-1')->first();


		if ($check_previous != null) {
			Game::where('game_id', $check_previous->game_id)->update(['status' => '1']);
			UserToGame::where('game_id', $check_previous->game_id)->update(['status' => '1']);
		}


		$symbol = '0';
		if ($game_id == 0) {
			$game = new Game;
			$game->creator_user_id = $user_id;
			$game->last_played_id = $user_id;
			$game->open = '1';
			$game->status = '0';
			$game->save();
			$game_id = $game->game_id;
		} elseif (Game::where('game_id', $game_id)->first()->open == '1') {
			$symbol = 'X';
			Game::where('game_id', $game_id)
					->update(['open' => '0', 'last_played_id' => $user_id]);
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

			$response = ['symbol' => $symbol, 'game_id' => $game_id];
			return $response;
		}
	}

}
