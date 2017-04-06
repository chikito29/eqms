@component('mail::message')
# Processing Revision Request

The Revision Request you submitted for <a href="{{ route('documents.show', $revisionRequest->reference_document->id) }}">{{ $revisionRequest->reference_document->title }}</a> was reviewed and has been approved by the QMR. Your Revision Request is now waiting for CEO's Approval.

<br><b>Reason for recommendation: </b>
@component('mail::panel')
{{ $revisionRequest->section_b->recommendation_reason }}
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@component('mail::subcopy')
<p style="text-align: center;">This is a computer generated email. Please do not reply. <br> For inquiries kindly email as at <a href="#">it@newsim.ph</a></p>
@endcomponent
@endcomponent
