<?php namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		$schedule->call(function()
		{
			\Log::info('minutely');
		})->cron('* * * * *');

		$schedule->call(function()
		{
			\Log::info('5 minutely');
		})->everyFiveMinutes();
		$schedule->call(function()
		{
			\Log::info('10 minutely');
		})->everyTenMinutes();

		

		$schedule->command('inspire')
				 ->hourly();
	}

}
