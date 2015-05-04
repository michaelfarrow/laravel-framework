<?php namespace App\Traits;

use \Closure;

trait FiresEvents {

	/**
	 * Create and fire a new event and 
	 *
	 * @return \App\Events\Event
	 */
	protected function fireEvent($name, $params = [], Closure $filter = null)
	{
		if (isset($this->eventNamespace))
			$name = $this->eventNamespace . '\\' . $name;

		$eventName = '\\App\\Events\\' . $name;
		// TODO: throw error if class does not exist

		$reflector = new \ReflectionClass($eventName);
		$event = $reflector->newInstanceArgs($params);

		if ($filter)
		{
			$event = $filter($event);
		}

		if (method_exists($this, 'filterEvent'))
		{
			$event = $this->filterEvent($event);
		}

		if (isset($this->events)) 
		{
			$this->events->first($event);
		} else {
			\Event::fire($event);
		}
	}

}
