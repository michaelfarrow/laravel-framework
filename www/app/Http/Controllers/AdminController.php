<?php namespace App\Http\Controllers;

abstract class AdminController extends AuthController
{

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->middleware('role.admin');
	}

}
