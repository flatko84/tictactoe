<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Activity;

class HomeController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$users = Activity::users()->get();
		$info = array();
		$info['users'] = array();
		foreach ($users as $user) {
			$info['users'][] = $user->user->name;
		}
		return view('home', $info);
	}

}
