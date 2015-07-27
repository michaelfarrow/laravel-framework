<?php namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Cache\CacheManager as Cache;

class VerifyHook {

	/**
	 * The number of days to keep the signature in cache for.
	 *
	 * @var Integer
	 */
	protected $cacheDays = 1;

	/**
	 * The current request being handled.
	 *
	 * @var \Illuminate\Http\Request
	 */
	protected $request;

	/**
	 * The cache manager.
	 *
	 * @var \Illuminate\Cache\CacheManager
	 */
	protected $cache;

		/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	public function __construct(Cache $cache)
	{
		$this->cache = $cache;
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
		$this->request = $request;

		return $this->verify()
			? $this->nextAndPreventReplay($next)
			: abort(401, 'Webook signature invalid');
	}

	/**
	 * Prevent further posts with the same signature
	 *
	 * @return mixed
	 */
	protected function nextAndPreventReplay(Closure $next)
	{
		$response = $next($this->request);

		$expire = Carbon::createFromTimestamp(
			$this->request->get('timestamp')
		)->addHours($this->cacheDays * 24);

		$this->cache->put($this->getCacheKey(), 1, $expire);

		return $response;
	}

	/**
	 * Verify post request
	 *
	 * @return Boolean
	 */
	protected function verify()
	{
		return $this->verifySignature()
			&& $this->verifyHandled()
			&& $this->verifyTimestamp();
	}

	/**
	 * Verify the signature
	 *
	 * @return Boolean
	 */
	protected function verifySignature()
	{
		list($timestamp, $token, $signature) = [
			$this->request->get('timestamp'),
			$this->request->get('token'),
			$this->request->get('signature'),
		];

		$key = config('services.mailgun.secret');

		$computedSig = $timestamp . $token;
		$computedSig = hash_hmac('sha256', $computedSig, $key);

		return $computedSig == $signature;
	}

	/**
	 * Verify that the request hasn't been handled yet
	 *
	 * @return Boolean
	 */
	protected function verifyHandled()
	{
		return ! $this->cache->has($this->getCacheKey());
	}

	/**
	 * Verify the request timestamp isn't too far in the past
	 *
	 * @return Boolean
	 */
	protected function verifyTimestamp()
	{
		$time = Carbon::createFromTimestamp(
			$this->request->get('timestamp')
		);

		$expire = Carbon::now()->subHours($this->cacheDays * 24 / 2);

		return $expire->lt($time);
	}

	/**
	 * Get cache key for request
	 *
	 * @return String
	 */
	protected function getCacheKey()
	{
		return 'verify_webhook_signature_' . $this->request->get('signature');
	}

}
