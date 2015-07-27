<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;

class HomeController extends AdminController {

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return $this->view('admin');
	}

}
