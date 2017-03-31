@component('mail::message')
# {{ $cpar->person_responsible }} CPAR has been reviewed

This is in regards with the CPAR issued to the above person.<br>
The QMR has reviewed the CPAR and came up with an appropriate action.<br>
Please see the CPAR in the provided link.

@component('mail::button', ['url' => route('cpars.show', $cpar->id)])
    Click here to view reviewed CPAR
@endcomponent

@slot('subcopy')
    <p style="text-align: center;">This is a computer generated email. Please do not reply. For inquiries kindly email as at <a href="#">it@newsim.ph</a></p>
@endslot
@endcomponent
