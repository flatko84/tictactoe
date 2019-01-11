<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model {

    protected $primaryKey = 'chat_id';
    protected $table = 'chat';

    public function games() {

        return $this->belongsTo('App\Game', 'game_id', 'game_id');
    }

    public function user_to_game() {

        return $this->belongsTo('App\UserToGame', 'user_game_id', 'user_game_id');
    }

    public function users() {

        return $this->belongsTo('App\User', 'user_id', 'id');
    }

}
