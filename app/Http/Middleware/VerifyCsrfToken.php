<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
use Illuminate\Routing\Router as Route;
use Illuminate\Contracts\Encryption\Encrypter;

class VerifyCsrfToken extends BaseVerifier {

	/**
	 * The router implementation.
	 *
	 * @var \Illuminate\Routing\Router
	 */
	protected $route;

	/**
	 * Array of route name regex to ignore.
	 *
	 * @var Array
	 */
	protected $routeNameIgnore = [
		'^welcome$',
	];

	/**
	 * Array of route path regex to ignore.
	 *
	 * @var Array
	 */
	protected $routePathIgnore = [
		'^hook\/'
	];

	/**
	 * Create a new middleware instance.
	 *
	 * @param  \Illuminate\Contracts\Encryption\Encrypter  $encrypter
	 * @param \Illuminate\Routing\Router $route
	 * @return void
	 */
	public function __construct(
		Encrypter $encrypter,
		Route $route
	) {
		$this->encrypter = $encrypter;
		$this->route = $route;
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
		$route = $this->route->getRoutes()->match($request);
		$ignore = false;

		if($route)
		{
			foreach ($this->routeNameIgnore as $ignoreName)
			{
				if(preg_match("/$ignoreName/", $route->getName()))
				{
					$ignore = true;
					break;
				}
			}

			foreach ($this->routePathIgnore as $ignorePath)
			{
				if(preg_match("/$ignorePath/", $route->getPath()))
				{
					$ignore = true;
					break;
				}
			}
		}

		if ($ignore)
		{
			return $next($request);
		}

		return parent::handle($request, $next);
	}

}
