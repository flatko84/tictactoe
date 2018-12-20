<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Turns extends Model
{
    protected $primaryKey = 'turn_id';
	protected $table = 'turns';
	
	public function games() {

		return $this->belongsTo('App\Game', 'game_id', 'game_id');
	}
	
	public function user_to_game() {

		return $this->belongsTo('App\UserToGame', 'user_game_id', 'user_game_id');
	}
	
}
