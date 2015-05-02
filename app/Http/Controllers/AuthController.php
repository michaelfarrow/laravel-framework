<?php namespace App\Http\Controllers;

abstract class AuthController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');

		parent::__construct();
	}

}
