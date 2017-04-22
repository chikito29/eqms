@component('mail::message')
# A CPAR has been reviewed and needs to have its CPAR number created

@component('mail::button', ['url' => route('cpars.index')])
Log in to eQMS
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
