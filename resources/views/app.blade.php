@extends('base')

@section('head.styles')
	@if(App::isLocal())
			<link media="all" type="text/css" rel="stylesheet" href="{{ asset('css/.compiled/app.css') }}">
		@else
			<link media="all" type="text/css" rel="stylesheet" href="{{ elixir('css/.minified/app.css') }}">
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
		<script src="{{ asset('js/.compiled/require.js') }}" data-main="{{ asset('js/main.app.js') }}"></script>
	@else
		<script src="{{ elixir('js/.minified/main.app.js') }}"></script>
	@endif

	<script>
		(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
		function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
		e=o.createElement(i);r=o.getElementsByTagName(i)[0];
		e.src='//www.google-analytics.com/analytics.js';
		r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
		ga('create','{{ env('GANALYTICS_ID', 'UA-XXXXX-X') }}',@if(App::isLocal()){'cookieDomain':'none'}@else'auto'@endif);ga('send','pageview');
	</script>
@endsection
