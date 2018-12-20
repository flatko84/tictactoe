<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Http\Request;
use App\UserToGame;
use App\Game;
use Illuminate\Support\Facades\Auth;

class UpdateController extends Controller {

	public function index($game_id) {
		$user_id = Auth::id();
		//date_default_timezone_set("Europe/Sofia");


		for ($i = 0; $i < 5; $i++) {



			$game = Game::where('game_id', $game_id)->where('status', '0')->first();

			$user_to_game = UserToGame::where('game_id', $game_id)->where('user_id', '!=', $user_id)->first();

			if ($user_to_game != null) {
				header('Cache-Control: no-cache');
				header("Content-Type: text/event-stream\n\n");
				$response['turn'] = unserialize($user_to_game->state);
				if ($user_to_game->status > -1) {
					$response['end'] = $user_to_game->status;
				}
				echo "event: ping\n";
				echo 'data: ' . json_encode($response);
				echo "\n\n";

				//echo 'data: This is a message at time ' . $curDate . "\n\n";
			}

			ob_end_flush();
			flush();
			sleep(3);
		}
	}

}
