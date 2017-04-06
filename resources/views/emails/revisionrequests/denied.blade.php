@component('mail::message')
# Denied Revision Request

The Revision Request you submitted for <a href="{{ route('documents.show', $revisionRequest->reference_document->id) }}">{{ $revisionRequest->reference_document->title }}</a> was reviewed and has been denied by the QMR.

<br><b>Reason for disapproval: </b>
@component('mail::panel')
{{ $revisionRequest->section_b->recommendation_reason }}
@endcomponent

@component('mail::button', ['url' => route('revision-requests.show', $revisionRequest->id)])
Login to view Revision Request
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@component('mail::subcopy')
<p style="text-align: center;">This is a computer generated email. Please do not reply. <br> For inquiries kindly email as at <a href="#">it@newsim.ph</a></p>
@endcomponent
@endcomponent
