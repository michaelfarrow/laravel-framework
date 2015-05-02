@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">{{ $page->title}}</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ route('admin.copy.do') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						@foreach($trans as $groupKey => $group)
							@foreach(array_dot($group) as $key => $value)
								<div class="form-group @if($errors->has($combinedKey = $groupKey . '[' . join('][', explode('.', $key)) . ']')) has-error @endif">
									<label class="col-md-4 control-label">{{ $combinedKey }}</label>
									<div class="col-md-6">
										<textarea class="form-control" name="{{ $combinedKey }}">{{ old($groupKey . '.' . $key) ?: $value }}</textarea>
									</div>
								</div>
							@endforeach
						@endforeach

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									{{ trans('copy.admin.actions.save') }}
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
