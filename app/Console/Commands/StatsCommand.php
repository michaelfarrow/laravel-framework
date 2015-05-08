<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use App\Models\Stat;

abstract class StatsCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = '';

	/**
	 * The stat name.
	 *
	 * @var string
	 */
	static public $statName = 'user';

	/**
	 * The console command schedule.
	 *
	 * @var string
	 */
	static public $schedule = 'everyFiveMinutes';

	/**
	 * The support periods.
	 *
	 * @var string
	 */
	static protected $supportedPeriods = [
		'all_time',
	];

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description.';

	/**
	 * Stores the calculated period.
	 *
	 * @var object
	 */
	protected $period = null;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->name = static::getStatPrefix() . static::getStatName();

		parent::__construct();
	}

	/**
	 * Get the supported periods.
	 *
	 * @return array
	 */
	public static function getSupportedPeriods()
	{
		return static::$supportedPeriods;
	}

	/**
	 * Get the default period.
	 *
	 * @return string
	 */
	public function getDefaultPeriodName()
	{
		return head(static::getSupportedPeriods());
	}

	/**
	 * Get the period name for the query.
	 *
	 * @return string
	 */
	protected function getPeriodName()
	{
		return $this->argument('period') ?: $this->getDefaultPeriodName();
	}

	/**
	 * Get the period dates for the query.
	 *
	 * @return object
	 */
	protected function getPeriod()
	{
		return (object) [
			'start' => null,
			'end'   => null,
		];
	}

	protected function setPeriod()
	{
		$this->period = $this->getPeriod();
	}

	/**
	 * Validate period.
	 *
	 * @return void
	 */
	protected function validatePeriod()
	{
		$period = $this->getPeriodName();

		if ( ! in_array($period, static::getSupportedPeriods()))
		{
			$this->error("Incorrect period '$period'");
			exit;
		}
	}

	/**
	 * Get the base query.
	 *
	 * @return Builder
	 */
	protected function getQuery()
	{
		return (object) [
			'function' => [$this, 'noop'],
			'args'     => [0],
		];
	}

	/**
	 * Alter the original query.
	 *
	 * @return Builder
	 */
	protected function alterQuery($query)
	{
		return $query;
	}

	/**
	 * Execute the query.
	 *
	 * @return Builder
	 */
	protected function executeQuery($query)
	{
		return call_user_func_array($query->function, $query->args);
	}

	/**
	 * Pre Process the result of the database query.
	 *
	 * @return Builder
	 */
	protected function preProcessResult($result)
	{
		return $result;
	}

	/**
	 * Process the result of the database query.
	 *
	 * @return Builder
	 */
	protected function processResult($result)
	{
		return $result;
	}

	/**
	 * Save the result to the database, or update any existing data.
	 *
	 * @return void
	 */
	protected function saveResult($result = null)
	{
		if ( ! is_null($result) && is_numeric($result))
		{
			$start = $this->period->start;
			$end = $this->period->end;

			$stat = Stat::firstOrNew([
				'start'  => $start,
				'name'   => $this->getStatName(),
				'period' => $this->getPeriodName(),
			]);

			$stat->value = $result;
			$stat->save();
		}
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		$this->validatePeriod();

		$query = $this->setPeriod();

		$query = $this->getQuery();
		$query = $this->alterQuery($query);

		$result = $this->executeQuery($query);
		$result = $this->preProcessResult($result);
		$result = $this->processResult($result);

		$this->saveResult($result);

		(new \Illuminate\Support\Debug\Dumper)->dump($result);
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['period', InputArgument::OPTIONAL, array_human(static::getSupportedPeriods(), ',', 'or'), $this->getDefaultPeriodName()],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [];
	}

	/**
	 * Get the console command options.
	 *
	 * @return string
	 */
	public static function getSchedule()
	{
		return static::$schedule;
	}

	/**
	 * Get the stat name.
	 *
	 * @return string
	 */
	public static function getStatName()
	{
		return static::$statName;
	}

	/**
	 * Get the stat prefix.
	 *
	 * @return string
	 */
	public static function getStatPrefix()
	{
		return 'stats:';
	}

	/**
	 * Standard passthrough function.
	 *
	 * @return mixed
	 */
	public function noop($value)
	{
		return $value;
	}

}
