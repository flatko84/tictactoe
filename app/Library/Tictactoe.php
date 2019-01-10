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

    public function calculateWin($fields) {
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

    public function Turn($cell) {

        
    }

}
