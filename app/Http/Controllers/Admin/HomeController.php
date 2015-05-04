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
		\Queue::push(function($job)
		{
		  \Log::info(config('app.test'));

		   $job->delete();
		});
		return $this->view('admin');
	}

}
