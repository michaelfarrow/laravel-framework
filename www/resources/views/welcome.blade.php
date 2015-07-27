@extends('app')

@section('content')
<div class="container">
	<div class="content">
		<h1 class="page-header">{{ $page->title }}</h1>
		<p class="lead">{{ Inspiring::quote() }}</p>
	</div>
</div>
@endsection