@component('mail::message')
# CPAR has been answered and finalized by department head {{ $cpar->department_head }}

The CPAR that has been issued to
@foreach($result as $employee)
    @if($employee->id == $cpar->person_responsible)
        {{ $employee->first_name }} {{ $employee->last_name }}
    @endif
@endforeach
{{ $cpar->created_at->diffForHumans() }} has been answered
and finalized and now ready to be reviewed.

@component('mail::button', ['url' => route('cpars.review', $cpar->id)])
    Click here to review cpar
@endcomponent

Thanks,
{{ config('app.name') }}

@slot('subcopy')
    <p style="text-align: center;">This is a computer generated email. Please do not reply. For inquiries kindly email as at <a href="#">it@newsim.ph</a></p>
@endslot
@endcomponent
