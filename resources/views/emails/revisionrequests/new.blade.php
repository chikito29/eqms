@component('mail::message')
# New Revision Request

You have a new revision request submission from <strong>{{ $revisionRequest->user_name }}</strong>, submitted on <i>{{ $revisionRequest->created_at->toDayDateTimeString() }}</i>.

<br><b>Reference document: </b>
@component('mail::panel')
<a href="{{ route('documents.show', $revisionRequest->reference_document->id) }}">{{ $revisionRequest->reference_document->title }}</a>
@endcomponent

<br><b>Reason for revision: </b>
@component('mail::panel')
{{ $revisionRequest->revision_reason }}
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
