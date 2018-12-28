<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('games', function (Blueprint $table) {
			$table->increments('game_id');
			$table->text('game_type');
			$table->integer('creator_user_id');
			$table->integer('last_played_id');
			$table->integer('open');
			$table->integer('status');
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('games');
	}

}
