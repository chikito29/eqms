@component('mail::message')
# Revision Request Approved

The Revision Request you submitted for <a href="{{ route('documents.show', $revisionRequest->reference_document->id) }}">{{ $revisionRequest->reference_document->title }}</a> was approved by the CEO.

Thanks,<br>
{{ config('app.name') }}
@component('mail::subcopy')
<p style="text-align: center;">This is a computer generated email. Please do not reply. <br> For inquiries kindly email as at <a href="#">it@newsim.ph</a></p>
@endcomponent
@endcomponent
