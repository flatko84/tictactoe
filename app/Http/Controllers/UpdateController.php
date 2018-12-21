<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Http\Request;
use App\UserToGame;
use App\Game;
use App\Turns;
use Illuminate\Support\Facades\Auth;

class UpdateController extends Controller {

	public function index($game_id) {
		$user_id = Auth::id();
		$end = 0;
		$force = 1;
		while ($end == 0) {

			$turn = Turns::where('game_id', $game_id)->where('user_id', '!=', $user_id)->where('sent', '0')->first();

			if ($turn != null) {
				$force = 0;
				Turns::where('turn_id', $turn->turn_id)->update(['sent' => '1']);
				header('Cache-Control: no-cache');
				header("Content-Type: text/event-stream\n\n");
				$response['turn'] = $turn->turn;
				if ($turn->user_to_game->status > -1) {
					$response['end'] = $turn->user_to_game->status;
					$end = 1;
				}
				echo "event: turn\n";
				echo 'data: ' . json_encode($response);
				echo "\n\n";
			} elseif ($force == 1) {

				header('Cache-Control: no-cache');
				header("Content-Type: text/event-stream\n\n");
				$response['turn'] = "success";

				echo "event: ping\n";
				echo 'data: ' . json_encode($response);
				echo "\n\n";
			}

			ob_end_flush();
			flush();
			sleep(3);
		}
	}

}
