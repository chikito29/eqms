@component('mail::message')
# CPAR has been issued

You are receiving this because an employee under the department {{ $cpar->department }} received a CPAR raised by
@foreach($employees as $employee)
    @if($employee->id == $cpar->raised_by)
        <strong>{{ $employee->first_name }} {{ $employee->last_name }}</strong>
    @endif
@endforeach,
created this {{ $cpar->created_at->format('l jS \\of F Y') }}.

Please inform
@foreach($employees as $employee)
    @if($employee->id == $cpar->person_responsible)
        <strong>{{ $employee->first_name }} {{ $employee->last_name }}</strong>
    @endif
@endforeach
to answer the CPAR on or before
{{ \App\Http\Controllers\CparController::holiday($cpar,2017,\Carbon\Carbon::parse($cpar->proposed_date),\Carbon\Carbon::parse($cpar->proposed_date)->diffInDays($cpar->created_at))->format('l jS \\of F Y') }}.

He/she may access the said CPAR using this code: <strong>{{ $cpar->responsiblePerson->code }}</strong>

Person responsible may answer the CPAR here: {{ route('answer-cpar-login', $cpar->id) }}

@component('mail::button', ['url' => route('cpars.show', $cpar->id)])
    Click here to view issued CPAR
@endcomponent

@slot('subcopy')
    <p style="text-align: center;">This is a computer generated email. Please do not reply. For inquiries kindly email as at <a href="#">it@newsim.ph</a></p>
@endslot
@endcomponent
