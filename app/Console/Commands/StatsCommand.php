<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Carbon\Carbon;
use DB;

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
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description.';

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

	/**
	 * Stores the calculated start date.
	 *
	 * @var Carbon\Carbon
	 */
	protected $startDate = null;

	/**
	 * Stores the calculated end date.
	 *
	 * @var Carbon\Carbon
	 */
	protected $endDate = null;

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
	 * Get a single query field.
	 *
	 * @return string
	 */
	protected function getQueryField()
	{
		$fields = $this->getQueryFields();

		return $fields[0];
	}

	/**
	 * Get the query fields.
	 *
	 * @return array
	 */
	protected function getQueryFields()
	{
		$fields = $this->queryField;
		if( ! is_array($fields)) $fields = [$fields];

		return $fields;
	}

	/**
	 * Create Carbon date from argument string.
	 *
	 * @param  string $date
	 * @return Carbon\Carbon
	 */
	protected function createDate($date)
	{
		return Carbon::createFromFormat('Y-m-d', $date);
	}

	/**
	 * Get the period dates for the query.
	 *
	 * @return object
	 */
	protected function getPeriod()
	{
		$period = $this->argument('period');
		$start = $this->argument('start');
		$now = Carbon::now();
		$end = null;

		switch ($period)
		{
			case 'all_time':
				$start = null;
				break;

			case 'month':
				$start = $start
					? $this->createDate($start)->startOfMonth()->startOfDay()
					: $now->startOfMonth()->startOfDay();
				break;

			case 'week':
				$start = $start
					? $this->createDate($start)->startOfWeek()->startOfDay()
					: $now->startOfWeek()->startOfDay();
				break;

			case 'day':
				$start = $start
					? $this->createDate($start)->startOfDay()
					: $now->startOfDay();
				break;
			
			default:
				$this->error("Incorrect period '$period'");
				exit;
				break;
		}

		switch ($period)
		{
			case 'month':
				$end = $start->copy()->addMonth();
				break;

			case 'week':
				$end = $start->copy()->addWeek();
				break;

			case 'day':
				$end = $start->copy()->addDay();
				break;
		}
		
		return (object) [
			'start' => $start,
			'end'   => $end,
		];

	}

	/**
	 * Get the base query.
	 *
	 * @return Builder
	 */
	protected function getQuery()
	{
		$query = DB::table($this->queryTable);

		$period = $this->getPeriod();
		
		if($period->start)
		{
			$this->startDate = $period->start;
			$query = $query->where($this->queryDateField, '>=', $period->start);
		}

		if($period->end)
		{
			$this->endDate = $period->end;
			$query = $query->where($this->queryDateField, '<', $period->end);
		}

		$earliest = $this->option('earliest');
		$latest = $this->option('latest');

		if($earliest)
			$query = $query->where($this->queryDateField, '>=', $this->createDate($earliest));

		if($latest)
			$query = $query->where($this->queryDateField, '<', $this->createDate($latest));

		return $query;
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
		switch ($this->queryType)
		{
			case 'count':
				$result = (int) $query->count();
				break;

			case 'sum':
				$result = (float) $query->sum($this->getQueryField());
				break;

			case 'average':
				$result = (float) $query->avg($this->getQueryField());
				break;
			
			default:
				$result = $query->get($this->getQueryFields());
				break;
		}

		return $result;
	}

	/**
	 * Pre Process the result of the database query.
	 *
	 * @return Builder
	 */
	protected function preProcessResult($result)
	{
		$fields = $this->getQueryFields();

		if(is_array($result) && count($fields) == 1)
		{
			foreach ($result as &$singleResult)
			{
				$singleResult = $singleResult->{$fields[0]};
			}
		}

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
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		$query = $this->getQuery();
		$query = $this->alterQuery($query);

		$result = $this->executeQuery($query);
		$result = $this->preProcessResult($result);
		$result = $this->processResult($result);

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
			['period', InputArgument::OPTIONAL, 'all_time, month, week, or day', 'all_time'],
			['start', InputArgument::OPTIONAL, 'Start date, defaults to current date, minus period specified', null],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			['earliest', null, InputOption::VALUE_OPTIONAL, 'Any dates before this will be ignored.', null],
			['latest', null, InputOption::VALUE_OPTIONAL, 'Any dates after this will be ignored.', null],
		];
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

}
