<?php namespace App\Handlers\Events;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class EmailEventHandler extends MultipleEventHandler {

	/**
	 * The event handler mappings for the multiple event handler.
	 *
	 * @var array
	 */
	protected $listen = [
		'App\Events\Email\EmailBounced'      => 'onBounced',
		'App\Events\Email\EmailClicked'      => 'onClicked',
		'App\Events\Email\EmailComplained'   => 'onComplained',
		'App\Events\Email\EmailDelivered'    => 'onDelivered',
		'App\Events\Email\EmailDropped'      => 'onDropped',
		'App\Events\Email\EmailOpened'       => 'onOpened',
		'App\Events\Email\EmailUnsubscribed' => 'onUnsubscribed',
	];

	/**
	 * Handle email bounced event.
	 *
	 * @param  $event
	 * @return void
	 */
	public function onBounced($event)
	{
		\Log::info('email:bounced:' . $event->timestamp . ':' . $event->email);
	}

	/**
	 * Handle email clicked event.
	 *
	 * @param  $event
	 * @return void
	 */
	public function onClicked($event)
	{
		\Log::info('email:clicked:' . $event->timestamp . ':' . $event->email);
	}

	/**
	 * Handle email complained event.
	 *
	 * @param  $event
	 * @return void
	 */
	public function onComplained($event)
	{
		\Log::info('email:complained:' . $event->timestamp . ':' . $event->email);
	}

	/**
	 * Handle email delivered event.
	 *
	 * @param  $event
	 * @return void
	 */
	public function onDelivered($event)
	{
		\Log::info('email:delivered:' . $event->timestamp . ':' . $event->email);
	}

	/**
	 * Handle email dropped event.
	 *
	 * @param  $event
	 * @return void
	 */
	public function onDropped($event)
	{
		\Log::info('email:dropped:' . $event->timestamp . ':' . $event->email);
	}

	/**
	 * Handle email opened event.
	 *
	 * @param  $event
	 * @return void
	 */
	public function onOpened($event)
	{
		\Log::info('email:opened:' . $event->timestamp . ':' . $event->email);
	}

	/**
	 * Handle email ubsubscribed event.
	 *
	 * @param  $event
	 * @return void
	 */
	public function onUnsubscribed($event)
	{
		\Log::info('email:ubsubscribed:' . $event->timestamp . ':' . $event->email);
	}

}
