<?php namespace App\Http\Controllers\Hooks;

use App\Http\Controllers\HookController;
use App\Traits\FiresEvents;
use BadMethodCallException;

class MailgunController extends HookController
{

	use FiresEvents;

	/**
	 * The event namespace.
	 *
	 * @var String
	 */
	protected $eventNamespace = 'Email';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('hook.verify');

		parent::__construct();
	}

	/**
	 * Handle all Mailgun webhooks
	 *
	 * @return Response
	 */
	public function anyIndex()
	{
		return $this->handle();
	}

	/**
	 * Handle valid post
	 *
	 * @return Response
	 * @throws \BadMethodCallException
	 */
	protected function handle()
	{
		$event = $this->request->get('event');
		$method = camel_case('handle_' . $event);

		if ( ! method_exists($this, $method))
		{
			throw new BadMethodCallException("Method [$method] does not exist.");
		}
		
		return call_user_func(array($this, $method));
	}

	/**
	 * Get standard event client variables.
	 *
	 * @return Array
	 */
	protected function getClientVars()
	{
		return [
			$this->request->get('ip'),
			$this->request->get('city'),
			$this->request->get('country'),
			$this->request->get('region'),
			$this->request->get('device-type'),
			$this->request->get('client-type'),
			$this->request->get('client-name'),
			$this->request->get('client-os'),
			$this->request->get('user-agent'),
		];
	}

	/**
	 * Add standard variables to event before firing.
	 *
	 * @param  \App\Events\Event $event
	 * @return \App\Events\Event
	 */
	protected function filterEvent($event)
	{
		return $event->set([
			'id' => $this->request->get('id'),
			'timestamp' => $this->request->get('timestamp'),
			'email' => $this->request->get('recipient'),
			'domain' => $this->request->get('domain'),
			'headers' => $this->request->get('message-headers'),
		]);
	}

	/**
	 * A successful delivery occrs when the recipient email
	 * server responds that it has accepted the message.
	 *
	 * @return Response
	 */
	protected function handleDelivered()
	{
		$this->fireEvent('EmailDelivered');

		return 'Delivered - OK';
	}

	/**
	 * There are several reasons why Mailgun stops attempting to
	 * deliver messages and drops them including: hard bounces,
	 * messages that reached their retry limit, previously
	 * unsubscribed/bounced/complained addresses, or addresses
	 * rejected by an ESP.
	 *
	 * @return Response
	 */
	protected function handleDropped()
	{
		$this->fireEvent('EmailDropped', [
			$this->request->get('code'),
			$this->request->get('description'),
			$this->request->get('reason'),
		]);

		return 'Dropped - OK';
	}

	/**
	 * When the recipient email server specifies that the
	 * recipient address does not exist.
	 *
	 * @return Response
	 */
	protected function handleBounced()
	{
		$this->fireEvent('EmailBounced', [
			$this->request->get('code'),
			$this->request->get('error'),
		]);

		return 'Bounced - OK';
	}

	/**
	 * When a user reports one of your emails as spam. Note that
	 * not all ESPs provide this feedback.
	 *
	 * @return Response
	 */
	protected function handleComplained()
	{
		$this->fireEvent('EmailComplained');

		return 'Complained - OK';
	}

	/**
	 * When a user unsubscribes, either from all messages,
	 * a specific tag or a mailing list.
	 *
	 * @return Response
	 */
	protected function handleUnsubscribed()
	{
		$tag = $this->request->get('tag');

		$this->fireEvent('EmailUnsubscribed', $this->getClientVars(),
			function($event) use ($tag)	{
				return $event->set('tag', $tag);
			}
		);

		return 'Unsubscribed - OK';
	}

	/**
	 * Every time a user clicks on a link in your messages.
	 *
	 * @return Response
	 */
	protected function handleClicked()
	{
		$url = $this->request->get('url');

		$this->fireEvent('EmailClicked', $this->getClientVars(),
			function($event) use ($url)	{
				return $event->set('url', $url);
			}
		);

		return 'Clicked - OK';
	}

	/**
	 * Every time a user opens one of your messages.
	 *
	 * @return Response
	 */
	protected function handleOpened()
	{
		$this->fireEvent('EmailOpened', $this->getClientVars());

		return 'Opened - OK';
	}

}
