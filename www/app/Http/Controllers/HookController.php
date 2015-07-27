<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Traits\ResolvesDependencies;

use Illuminate\Http\Request;

abstract class HookController extends BaseController
{

	use ResolvesDependencies;

	/**
	 * The request implementation.
	 *
	 * @var \Illuminate\Http\Request
	 */
	protected $request;

	/**
	 * Create a new controller instance.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Illuminate\Contracts\Events\Dispatcher $events
	 * @return void
	 */
	public function __construct(
		Request $request = null
	) {
		$this->resolve();
	}

}
