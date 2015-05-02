<?php namespace App\Http\Controllers;

abstract class AdminController extends AuthController
{

	public function __construct()
	{
		parent::__construct();

		$this->middleware('role.admin');
	}

}
