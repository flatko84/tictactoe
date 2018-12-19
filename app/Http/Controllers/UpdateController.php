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
		header('Cache-Control: no-cache');
		header("Content-Type: text/event-stream\n\n");


		
			$game = Game::where('game_id', $game_id)->where('status','0')->first();
			
			$user_to_game = UserToGame::where('game_id',$game_id)->where('user_id','!=',$user_id)->first();
			
			if ($user_to_game != null){
			$response = unserialize($user_to_game->state);
			
			
			echo "event: ping\n";
			echo 'data: ' . json_encode($response);
			echo "\n\n";

			//echo 'data: This is a message at time ' . $curDate . "\n\n";
			}

			ob_end_flush();
			flush();
			
			
			
		
	}

}
