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
