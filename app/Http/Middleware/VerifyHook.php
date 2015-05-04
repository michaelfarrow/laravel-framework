<?php namespace App\Http\Middleware;

use Closure;

class VerifyHook {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		return $this->verify($request)
			? $next($request)
			: abort(401, 'Webook signature does not match');
	}

	/**
	 * Verify post request
	 *
	 * @return Boolean
	 */
	protected function verify($request)
	{
		list($timestamp, $token, $signature) = [
			$request->get('timestamp'),
			$request->get('token'),
			$request->get('signature'),
		];

		$key = config('services.mailgun.secret');

		$test = $timestamp . $token;
		$test = hash_hmac('sha256', $test, $key);

		return $test == $signature;
	}

}
