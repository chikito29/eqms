if($('title').html() == ' Appeal | eQMS ') {
	$('.page-title').html('<h2><span class="fa fa-legal"></span> Revision Request - Appeal </h2>');
	denied =
	'<div class="form-group">' +
		'<label class="col-md-2 col-xs-5 control-label">Denied Request</label>' +
		'<div class="col-md-10 col-xs-7">' +
			'<a class="control-label" style="font-size: 1.5em;" href="{{ route('revision-requests.show', $revisionRequest->id) }}" target="_blank">Click here to view denied Revision Request</a>' +
		'</div>' +
	'</div>';
	$('#main-panel').prepend(denied);
}
