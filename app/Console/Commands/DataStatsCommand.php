<?php namespace App\Console\Commands;

use App\Console\Commands\StatsCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Carbon\Carbon;
use Statistics;
use DB;

abstract class DataStatsCommand extends StatsCommand {

	/**
	 * The support periods.
	 *
	 * @var string
	 */
	static protected $supportedPeriods = [
		'all_time',
		'month',
		'week',
		'day',
	];

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
	 * Get the period dates for the query.
	 *
	 * @return object
	 */
	protected function getPeriod()
	{
		$period = $this->getPeriodName();
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
					? Statistics::createDate($start)->startOfMonth()->startOfDay()
					: $now->startOfMonth()->startOfDay();
				break;

			case 'week':
				$start = $start
					? Statistics::createDate($start)->startOfWeek()->startOfDay()
					: $now->startOfWeek()->startOfDay();
				break;

			case 'day':
				$start = $start
					? Statistics::createDate($start)->startOfDay()
					: $now->startOfDay();
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

		$period = $this->period;
		
		if($period->start)
		{
			$query = $query->where($this->queryDateField, '>=', $period->start);
		}

		if($period->end)
		{
			$query = $query->where($this->queryDateField, '<', $period->end);
		}

		$earliest = $this->option('earliest');
		$latest = $this->option('latest');

		if($earliest)
			$query = $query->where($this->queryDateField, '>=', Statistics::createDate($earliest));

		if($latest)
			$query = $query->where($this->queryDateField, '<', Statistics::createDate($latest));

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
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['period', InputArgument::OPTIONAL, array_human(static::getSupportedPeriods(), ',', 'or'), $this->getDefaultPeriodName()],
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

}
