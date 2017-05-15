@foreach($cpars as $cpar)
	@if(request('user.role') != 'default')
		<tr>
			<td>{{ $cpar->cpar_number }}</td>
			<td>
				@foreach($employees as $employee)
					@if($employee->id == $cpar->raised_by)
						{{ $employee->first_name }} {{ $employee->last_name }}
					@endif
				@endforeach
			</td>
			<td>{!! $cpar->severity !!}</td>
			<td>{{ $cpar->created_at->toDayDateTimeString() }}</td>
			<td>
				@include('components.status', compact('cpar'))
			</td>
			<td>
				@component('components.button-state', compact('cpar')) @slot('title') view @endslot view @endcomponent
				@if($cpar->raised_by == request('user.id'))
					@component('components.button-state', compact('cpar')) @slot('title') edit @endslot edit @endcomponent
				@endif
				@if(request('user.role') != 'default')
					@if($cpar->cpar_number == null)
						@component('components.button-state', compact('cpar')) @slot('title') Create CPAR Number @endslot Create CPAR Number @endcomponent
					@elseif($cpar->cparReviewed->status == 1 && $cpar->cpar_number <> null)
						@component('components.button-state', compact('cpar')) @slot('title') Print Reviewed CPAR @endslot Print Reviewed CPAR @endcomponent
					@elseif($cpar->cparReviewed->status == 0 && $cpar->cpar_number == null && $cpar->cparReviewed->status <> 1)
						@component('components.button-state', compact('cpar')) @slot('title') Print Closed CPAR @endslot Print Closed CPAR @endcomponent
					@else
						@component('components.button-state', compact('cpar')) @slot('title') review @endslot review @endcomponent
					@endif
				@endif
				@component('components.button-state', compact('cpar')) @slot('title') close @endslot close @endcomponent
			</td>
			<form method="get" id="edit{{ $cpar->id }}"><input type="text" class="form-control hidden" name="cpar_number"></form>
			<form method="get" action="{{ route('cpars.close', $cpar->id) }}" accept-charset="UTF-8" id="close{{ $cpar->id }}">
				{{ csrf_field() }}
				{{ method_field('delete') }}
				<input type="text" class="form-control hidden" name="cpar_id">
			</form>
		</tr>
	@else
		@if((request('user.branch') == $cpar->branch && request('user.department') == $cpar->department)
		|| request('user.id') == $cpar->raised_by || request('user.id') == $cpar->chief)
			<tr>
				<td>{{ $cpar->cpar_number }}</td>
				<td>
					@foreach($employees as $employee)
						@if($employee->id == $cpar->raised_by)
							{{ $employee->first_name }} {{ $employee->last_name }}
						@endif
					@endforeach
				</td>
				<td>{!! $cpar->severity !!}</td>
				<td>{{ $cpar->created_at->toDayDateTimeString() }}</td>
				<td>
					@include('components.status', compact('cpar'))
				</td>
				<td>
					@component('components.button-state', compact('cpar')) @slot('title') view @endslot view @endcomponent
					@if($cpar->raised_by == request('user.id'))
						@component('components.button-state', compact('cpar')) @slot('title') edit @endslot edit @endcomponent
					@endif
					@if(! App\HelperClasses\User::isDefault())
						@if($cpar->cpar_number == null)
							@component('components.button-state', compact('cpar')) @slot('title') Create CPAR Number @endslot Create CPAR Number @endcomponent
						@elseif($cpar->cparReviewed->status == 1 && $cpar->cpar_number <> null)
							@component('components.button-state', compact('cpar')) @slot('title') Print Reviewed CPAR @endslot Print Reviewed CPAR @endcomponent
						@elseif($cpar->cparReviewed->status == 0 && $cpar->cpar_number == null && $cpar->cparReviewed->status <> 1)
							@component('components.button-state', compact('cpar')) @slot('title') Print Closed CPAR @endslot Print Closed CPAR @endcomponent
						@else
							@component('components.button-state', compact('cpar')) @slot('title') review @endslot review @endcomponent
						@endif
					@endif
					@component('components.button-state', compact('cpar')) @slot('title') close @endslot close @endcomponent
				</td>
				<form method="get" id="edit{{ $cpar->id }}"><input type="text" class="form-control hidden" name="cpar_number"></form>
				<form method="get" action="{{ route('cpars.close', $cpar->id) }}" accept-charset="UTF-8" id="close{{ $cpar->id }}">
					{{ csrf_field() }}
					{{ method_field('delete') }}
					<input type="text" class="form-control hidden" name="cpar_id">
				</form>
			</tr>
		@else
			@continue
		@endif
	@endif
@endforeach
