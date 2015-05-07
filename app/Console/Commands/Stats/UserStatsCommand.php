<?php namespace App\Console\Commands\Stats;

use App\Console\Commands\StatsCommand;

class UserStatsCommand extends StatsCommand {

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

	/**
	 * The date/time field to use in the query.
	 *
	 * @var string
	 */
	protected $queryDateField = 'created_at';

	/**
	 * The field to quantify.
	 *
	 * @var string
	 */
	protected $queryField = 'id';

	/**
	 * The quantify action to take.
	 *
	 * @var string
	 */
	protected $queryType = 'count';

}
