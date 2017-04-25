<div class="form-group">
	<label class="col-md-2 col-xs-5 control-label">Old Attachments</label>
	<div class="col-md-10 col-xs-7">
		<label class="check"><input type="checkbox" class="icheckbox" name="use_attachment"/> Use as appeal's attachment/s</label><br>
		@if(count($revisionRequest->attachments->where('section', 'revision-request-a')) > 0)
			@foreach($revisionRequest->attachments->where('section', 'revision-request-a') as $attachment)
				<a class="control-label" href="{{ url($attachment->file_path) }}" target="_blank">{{ $attachment->file_name }}</a><br>
			@endforeach
		@else
			<label class="control-label">None</label>
		@endif
	</div>
</div>
