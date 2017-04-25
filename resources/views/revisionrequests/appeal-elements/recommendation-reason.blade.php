<div class="form-group">
	<label class="col-md-2 col-xs-12 control-label">Recommendation Reason</label>
	<div class="col-md-10 col-xs-12">
		<span class="label label-danger" style="font-size: 1em;">Revision Request has been denied because</span><br><br>
		<div class="panel-body" style="background-color: rgb(249,249,249); padding: 20px; border-radius: 5px;">
			{{ $revisionRequest->section_b->recommendation_reason }}
		</div>
	</div>
</div>
