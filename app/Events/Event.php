<?php namespace App\Events;

use Illuminate\Queue\SerializesModels;

class Event {

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct()
	{

	}

	/**
	 * Set parameter.
	 *
	 * @return App\Events\Event
	 */
	public function set($names, $value = null)
	{
		if (!is_array($names))
		{
			$name = $names;
			$names = [];
			$names[$name] = $value;
		}

		foreach ($names as $key => $value)
		{
			$this->{$key} = $value;
		}

		return $this;
	}

}
