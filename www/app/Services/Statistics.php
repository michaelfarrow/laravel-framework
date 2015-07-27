<?php namespace App\Services;

use App\Models\Stat;
use Carbon\Carbon;

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

			$commandName = $command::getStatPrefix() . $command::getStatName();
			$variants = $command::getSupportedPeriods();

			foreach ($variants as $variant) {
				call_user_func([
					$schedule->command(
						$commandName . ' ' . $variant
					),
					$period
				]);
			}
		}
	}

	/**
	 * Create Carbon date from argument string.
	 *
	 * @param  string $date
	 * @return Carbon\Carbon
	 */
	public function createDate($date)
	{
		return Carbon::createFromFormat('Y-m-d', $date);
	}

	protected function constructHtml($data){
		$chartId = 'chart_' . uniqid();

		$html = "<script>var $chartId = " . json_encode($data) . ";</script>";
		$html .= "<div class=\"chart-wrapper\"><canvas class=\"stats-chart\" id=\"$chartId\" width=\"400\" height=\"400\"></canvas></div>";

		return $html;
	}

	public function lineChart($data)
	{
		$labels = [];

		foreach ($data[0] as $values) {
			$labels[] = 'test';
		}

		$return = [
			'type' => 'line',
			'data' => [
				'labels'   => $labels,
				'datasets' => [],
			],
		];

		foreach ($data as $values)
		{
			$return['data']['datasets'][] = [
				"label" => "My First dataset",
				"fillColor" => "rgba(220,220,220,0.2)",
				"strokeColor" => "rgba(220,220,220,1)",
				"pointColor" => "rgba(220,220,220,1)",
				"pointStrokeColor" => "#fff",
				"pointHighlightFill" => "#fff",
				"pointHighlightStroke" => "rgba(220,220,220,1)",
				"data" => $values,
			];
		}

		return $this->constructHtml($return);
	}

	public function doughnutChart($data, $unit = '')
	{
		return $this->pieChart($data, $unit, true);
	}

	public function pieChart($data, $unit = '', $doughnut = false)
	{
		$return = [
			'type' => $doughnut ? 'doughnut' : 'pie',
			'data' => [],
		];

		foreach ($data as $value)
		{
			$return['data'][] = [
				'value' => $value,
				'color' => '#46BFBD',
				'highlight' => '#5AD3D1',
				'label' => 'test',
			];
		}

		return $this->constructHtml($return);
	}

	// Sort this heap of shit out

	public function get($name, $period, $start = null, $end = null)
	{
		$now = Carbon::now();

		$start = $start ? $this->createDate($start) : $now->copy()->subWeek() ;
		$end = $end ? $this->createDate($end) : $now->copy();

		if($period == 'all_time')
		{
			$start = null;
			$end = null;
		}

		$stats = Stat::where('name', '=', $name)
			->where('period', '=', $period);

		if($start) $stats = $stats->where('start', '>=', $start);
		if($end) $stats = $stats->where('start', '<', $end);

		$return = $stats->orderBy('start')->lists('value');

		if($period == 'all_time')
		{
			if(count($return) != 0)
			{
				return $return[0];
			}
			else
			{
				return 0;
			}
		}
		else
		{
			return $return;
		}
	}

}
