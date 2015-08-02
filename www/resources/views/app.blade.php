@extends('base')

@section('head.styles')
	<link media="all" type="text/css" rel="stylesheet" href="{{ build_asset('css/app.css') }}">
@endsection

@section('head.scripts')
	<script src="{{ build_asset('js/vendor/modernizr.js') }}"></script>
@endsection

@section('foot.scripts')
	<script src="{{ build_asset('js/vendor/require.js') }}" data-main="{{ build_asset('js/main.app.js') }}"></script>

	<script>
		(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
		function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
		e=o.createElement(i);r=o.getElementsByTagName(i)[0];
		e.src='//www.google-analytics.com/analytics.js';
		r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
		ga('create','{{ env('GANALYTICS_ID', 'UA-XXXXX-X') }}',@if(App::isLocal()){'cookieDomain':'none'}@else'auto'@endif);ga('send','pageview');
	</script>
@endsection
