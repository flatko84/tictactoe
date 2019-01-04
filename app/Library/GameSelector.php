<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Library;

use App\Library\Tictactoe;
/**
 * Description of GameStrategy
 *
 * @author vdonkov
 */
class GameSelector {
	
	private $game;
	public function newGame($game_type){
		
		$this->game = new Tictactoe();
		return $this->game;
	}
}
