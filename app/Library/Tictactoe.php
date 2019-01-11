<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Library;

/**
 * Description of Tictactoe
 *
 * @author vdonkov
 */
class Tictactoe implements GameInterface {

	private $game_mode = 2;

	public function getGameMode() {
		return $this->game_mode;
	}

	public function Turn($user_id, $user_game, $turns, $cell) {


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

			$response = array(
				'cell' => $cell
			);

//			if ($this->calculateWin($user_game_state) == 1) {
//				$response['end'] = '2';
//				$response['other_result'] = '0';
//			} elseif (count($game_state) == 9) {
//				$response['end'] = '1';
//				$response['other_result'] = '1';
//			}
			return $response;
		} else {
			return false;
		}
	}

	protected function calculateWin($fields) {
		$win_combinations = [['1', '2', '3'],
			['4', '5', '6'],
			['7', '8', '9'],
			['1', '4', '7'],
			['2', '5', '8'],
			['3', '6', '9'],
			['1', '5', '9'],
			['3', '5', '7']];
		$result = 0;

		foreach ($win_combinations as $win_combination) {
			$occurence = 0;
			foreach ($win_combination as $win_field) {
				if (in_array($win_field, $fields)) {
					$occurence++;
				}
			}
			if ($occurence == 3) {
				$result = 1;
			}
		}
		return $result;
	}

}
