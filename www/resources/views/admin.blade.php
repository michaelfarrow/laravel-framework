@extends('base')

@section('head.styles')
	<link media="all" type="text/css" rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('head.scripts')
	<script src="{{ build_asset('js/vendor/modernizr.js') }}"></script>
@endsection

@section('foot.scripts')
	<script src="{{ asset('js/vendor/require.js') }}" data-main="{{ asset('js/main.admin.js') }}"></script>
@endsection

@section('content')
	<div class="container">

		{!! Statistics::doughnutChart(
			[
				$space = Statistics::get('disk-space', 'all_time'),
				100 - $space,
			],
			'%'
		) !!}

		{!! Statistics::lineChart([
			Statistics::get('user', 'day', \Carbon\Carbon::now()->subWeek()->format('Y-m-d'), \Carbon\Carbon::now()->format('Y-m-d')),
			Statistics::get('disk-space', 'month', \Carbon\Carbon::now()->subWeek()->format('Y-m-d'), \Carbon\Carbon::now()->format('Y-m-d')),
		]) !!}

		{{--<div class="chart-container">
			<script>
				var stats_chart_data_myChart = [
					[65, 59, 80, 81, 56, 55, 40],
					[28, 48, 40, 19, 86, 27, 90]
				];
			</script>
			<canvas class="stats-chart" id="myChart" width="400" height="400"></canvas>
		</div>
		--}}
	</div>
@endsection