<?php namespace App\Http\Controllers;

abstract class AuthController extends Controller
{

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');

		parent::__construct();
	}

}
