<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Statistics;

class StatsServiceProvider extends ServiceProvider {

	/**
	 * The stats commands to register on boot.
	 *
	 * @var string
	 */
	protected $statCommands = [
		'App\Console\Commands\Stats\UserStatsCommand',
		'App\Console\Commands\Stats\RoleStatsCommand',
	];

	/**
	 * Register the application service.
	 *
	 * @return void
	 */
	public function register()
	{
		$statCommands = $this->statCommands;

		$statistics = new Statistics;
		$statistics->register($statCommands);

		$this->app->instance('Statistics', $statistics);
	}

}
