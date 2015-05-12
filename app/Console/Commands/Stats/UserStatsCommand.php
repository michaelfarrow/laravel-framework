<?php namespace App\Console\Commands\Stats;

use App\Console\Commands\DataStatsCommand;

class UserStatsCommand extends DataStatsCommand {

	/**
	 * The stat name.
	 *
	 * @var string
	 */
	static public $statName = 'user';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'User count';

	/**
	 * The database table to search within.
	 *
	 * @var string
	 */
	protected $queryTable = 'users';

}
