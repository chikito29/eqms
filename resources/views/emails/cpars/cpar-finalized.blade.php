@component('mail::message')
# CPAR has been answered and finalized by department head {{ $cpar->department_head }}

The CPAR that has been issued to {{ $cpar->person_responsible }} {{ $cpar->created_at->diffForHumans() }} has been answered
and finalized and now ready to be reviewed.

@component('mail::button', ['url' => route('cpars.verify', $cpar->id)])
    Click here to review cpar
@endcomponent

Thanks,
{{ config('app.name') }}

@slot('subcopy')
    <p style="text-align: center;">This is a computer generated email. Please do not reply. For inquiries kindly email as at <a href="#">it@newsim.ph</a></p>
@endslot
@endcomponent
