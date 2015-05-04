<?php namespace App\Handlers\Events;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class UserEventHandler extends MultipleEventHandler {

	/**
	 * The event handler mappings for the multiple event handler.
	 *
	 * @var array
	 */
	protected $listen = [
		'auth.login'   => 'onLogin',
		'auth.attempt' => 'onAttempt',
		'auth.logout'  => 'onLogout',
	];

	/**
	 * Handle user login event.
	 *
	 * @param  $event
	 * @return void
	 */
	public function onLogin($event)
	{
		\Log::info('login');
	}

	/**
	 * Handle user attempt event.
	 *
	 * @param  $event
	 * @return void
	 */
	public function onAttempt($event)
	{
		\Log::info('attempt');
	}

	/**
	 * Handle user login event.
	 *
	 * @param  $event
	 * @return void
	 */
	public function onLogout($event)
	{
		\Log::info('logout');
	}

}
