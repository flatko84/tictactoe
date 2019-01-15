<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Library\Games;

use App\Library\GameInterface;

/**
 * Description of Go
 *
 * @author vdonkov
 */
class Go implements GameInterface {

	private $game_mode = 2;

	public function getGameMode() {
		return $this->game_mode;
	}

	public function Turn($user_id, $user_game, $turns, $cell) {
		
	}

}
