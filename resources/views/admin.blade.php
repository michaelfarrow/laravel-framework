@extends('base')

@section('head.styles')
	@if(App::isLocal())
			<link media="all" type="text/css" rel="stylesheet" href="{{ asset('css/.compiled/admin.css') }}">
		@else
			<link media="all" type="text/css" rel="stylesheet" href="{{ elixir('css/.minified/admin.css') }}">
		@endif
@endsection

@section('head.scripts')
	@if(App::isLocal())
		<script src="{{ asset('js/.compiled/modernizr.js') }}"></script>
		<script src="{{ asset('js/modernizr/highres.js') }}"></script>
	@else
		<script src="{{ elixir('js/.minified/modernizr.js') }}"></script>
		<script src="{{ elixir('js/.minified/highres.js') }}"></script>
	@endif
@endsection

@section('foot.scripts')
	@if(App::isLocal())
		<script src="{{ asset('js/.compiled/require.js') }}" data-main="{{ asset('js/main.admin.js') }}"></script>
	@else
		<script src="{{ elixir('js/.minified/main.admin.js') }}"></script>
	@endif
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