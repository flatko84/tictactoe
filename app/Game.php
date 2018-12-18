<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model {

	protected $primaryKey = 'game_id';
	protected $table = 'games';
	public $timestamps = false;
	
	public function users() {

		return $this->belongsTo('App\User', 'user_id', 'id');
	}

}
