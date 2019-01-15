<?php

namespace App\Http\Middleware;

use Closure;

class ValidateGame {

	public function handle($request, Closure $next) {
		$game_type = $request->route('game_type');
		if (!class_exists("\\App\\Library\\Games\\" . ucfirst($game_type))) {
			return redirect('home');
		}
		return $next($request);
	}

}
