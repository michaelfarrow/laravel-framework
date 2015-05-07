<?php namespace App\Services;

class Statistics {

	protected $commands = [];

	/**
	 * Register the statistics commands.
	 *
	 * @param  array|string $names
	 * @return void
	 */
	public function register($names)
	{
		if( ! is_array($names))
		{
			$names = [$names];
		}

		foreach ($names as $name)
		{
			if( ! in_array($name, $this->commands))
				array_push($this->commands, $name);
		}
	}

	/**
	 * Get the statistic commands.
	 *
	 * @param  array|string $names
	 * @return void
	 */
	public function commands()
	{
		return $this->commands;
	}

	/**
	 * Schedule commands.
	 *
	 * @param  array|string $names
	 * @return void
	 */
	public function schedule($schedule)
	{
		foreach ($this->commands() as $command)
		{
			$period = $command::getSchedule();

			call_user_func([
				$schedule->command(
					$command::getStatPrefix() . $command::getStatName()
				),
				$period
			]);
		}
	}

}