<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ $page->fullTitle }}</title>

		@yield('head.styles')
		@yield('head.scripts')

</head>
<body id="route-{{ join($page->routeParts, '_') }}" class="route-{{ join($page->routeParts, ' route-') }}">
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ route('welcome') }}">{{ $page->siteTitle }}</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				@if (Auth::guest())
					<ul class="nav navbar-nav navbar-right">
						<li><a href="{{ route('auth.login') }}">{{ trans('copy.auth.login.title') }}</a></li>
						<li><a href="{{ route('auth.register') }}">{{ trans('copy.auth.register.title') }}</a></li>
					</ul>
				@else
					<p class="navbar-text navbar-right">{{ Auth::user()->name }} <a href="{{ route('auth.logout') }}">{{ trans('copy.auth.actions.logout') }}</a></p>
				@endif
			</div>
		</div>
	</nav>

	@yield('content')

	@yield('foot.scripts')

	</body>
</body>
</html>
