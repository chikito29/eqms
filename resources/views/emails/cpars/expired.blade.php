@component('mail::message')

# CPAR expired

The CPAR that has been issued to
@foreach($result as $employee)
    @if($employee->id == $cpar->person_responsible)
        {{ $employee->first_name }} {{ $employee->last_name }}
    @endif
@endforeach
, last {{ $cpar->created_at->toDayDateTimeString() }},
have been unanswered and expired {{ $cpar->updated_at->toDayDateTimeString() }}.

@slot('subcopy')
    <p style="text-align: center;">This is a computer generated email. Please do not reply. For inquiries kindly email as at <a href="#">it@newsim.ph</a></p>
@endslot

@endcomponent


