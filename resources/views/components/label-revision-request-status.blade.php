@if($slot == 'New')
    <span class="label label-info" style="color: white;">{{ $slot }}</span>
@elseif($slot == 'Processing')
    <span class="label label-warning" style="color: white;">{{ $slot }}</span>
@elseif($slot == 'Approved')
    <span class="label label-success" style="color: white;">{{ $slot }}</span>
@elseif($slot == 'Denied')
    <span class="label	label-danger" style="color: white;">
		{{ $slot }}
		@if($revisionRequest->has_appeal == 1)
			<span class="glyphicon glyphicon-link" style="color:black"></span>
		@endif
	</span>

@elseif($slot == 'Appeal')
	<span class="label label-warning" style="color: white;">{{ $slot }}</span>
@endif
