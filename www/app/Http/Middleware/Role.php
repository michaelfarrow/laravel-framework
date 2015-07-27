<?php namespace App\Http\Middleware;

use Closure;
use App;
use Illuminate\Contracts\Auth\Guard;

class Role {

	/**
	 * The Role to restrict.
	 *
	 * @var string
	 */
	protected $role = 'user';

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if(!$this->auth->check() || !$this->auth->user()->hasRole($this->role)){
			App::abort(401);
		}

		return $next($request);
	}

}
