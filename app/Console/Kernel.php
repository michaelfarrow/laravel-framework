<?php namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Foundation\Application;

class Kernel extends ConsoleKernel {

	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		'App\Console\Commands\Inspire',
	];

	/**
	 * Merge the commands array with the the commands
	 * of the application service providers.
	 *
	 * @return void
	 */
	function updateCommands($schedule)
	{
		$statistics = app()->make('statistics');

		$this->commands = array_merge(
			$this->commands,
			$statistics->commands()
		);

		$statistics->schedule($schedule);
	}

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		$this->updateCommands($schedule);
	}

}
