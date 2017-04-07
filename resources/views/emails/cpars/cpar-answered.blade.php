@component('mail::message')
# CPAR has been answered

The CPAR that has been issued to
@foreach($employees as $employee)
    @if($employee->id == $cpar->person_responsible)
        {{ $employee->first_name }} {{ $employee->last_name }}
    @endif
@endforeach
{{ $cpar->created_at->diffForHumans() }} has been answered
and needs to be validated before the QMR's review process to take place.

@component('mail::button', ['url' => route('cpars.verify', $cpar->id)])
    Click here to verify cpar
@endcomponent

Thanks,
{{ config('app.name') }}

@slot('subcopy')
    <p style="text-align: center;">This is a computer generated email. Please do not reply. For inquiries kindly email as at <a href="#">it@newsim.ph</a></p>
@endslot
@endcomponent
