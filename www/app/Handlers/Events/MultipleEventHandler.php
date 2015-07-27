<?php namespace App\Handlers\Events;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class MultipleEventHandler {

	/**
	 * The event handler mappings for the multiple event handler.
	 *
	 * @var array
	 */
	protected $listen = [];

	/**
	 * Add all the listeners for the multiple event handler.
	 *
	 * @param  \Illuminate\Contracts\Events\Dispatcher  $events
	 * @return void
	 */
	public function subscribe(DispatcherContract $events)
	{
		foreach ($this->listen as $event => $listener)
		{
			$events->listen($event, get_class($this) . '@' . $listener);
		}
	}

}
