@if($slot == 'For Approval')
    <span class="label label-success" style="color: white;">{{ $slot }}</span>
@else
    <span class="label label-danger" style="color: white;">{{ $slot }}</span>
@endif
