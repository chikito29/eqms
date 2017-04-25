@extends('revisionrequests.create')

@section('page-title') Appeal | eQMS @stop

@section('post-scripts')
	<script>
		//populate tags
		tags = "";
		@foreach(explode( ',', $revisionRequest->reference_document_tags ) as $reference_document_tags)
			tags += '{{ $reference_document_tags }}' + ',';
		@endforeach

		$('#tags').val(tags);

		$('#revision-form').attr('action', '{{ route('revision-requests.store-appeal', $revisionRequest->id, "old_revision_request=$revisionRequest->id") }}');
	</script>
@stop
