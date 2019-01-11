<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Library;

/**
 *
 * @author vdonkov
 */
interface GameInterface {

	public function getGameMode();

	public function Turn($user_id, $user_game, $turns, $cell);
}
