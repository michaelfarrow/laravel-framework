<?php namespace App\Console\Commands\Stats;

use App\Console\Commands\StatsCommand;

class DiskSpaceStatsCommand extends StatsCommand {

	/**
	 * The stat name.
	 *
	 * @var string
	 */
	static public $statName = 'disk-space';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Disk space';

	/**
	 * Get the base query.
	 *
	 * @return Builder
	 */
	protected function getQuery()
	{
		return (object) [
			'function' => [$this, 'getDiskSpace'],
			'args'     => [storage_path()],
		];
	}

	/**
	 * Get the current used space in percent.
	 *
	 * @param  string $path
	 * @return float
	 */
	public function getDiskSpace($path)
	{
		return 100 - (disk_free_space($path) / disk_total_space($path) * 100);
	}

}
