@extends('layouts.main')

@section('page-title')New Revision Request | eQMS @endsection

@section('nav-view') active @endsection

@section('page-content')
<div class="page-content-wrap">
	@if($errors->has('attachments'))
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<strong>Woops!</strong> One of the following fields <em>must</em> be filled:<br>
			<ul>
				<li> <strong>Proposed Revision</strong> </li>
				<li> <strong>Attachments</strong> </li>
			</ul>
		</div>
	@endif
    <div class="page-title">
        <h2><span class="fa fa-pencil"></span> Revision Request</h2>
    </div>

    <div class="row">
        <div class="col-md-9">

            <form enctype="multipart/form-data" class="form-horizontal" action="{{ route('revision-requests.store') }}" method="POST" role="form" id="revision-form">
                {{ csrf_field() }}
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3>Section A: Formal Request</h3>
                        <p>This is to formalize a request for a revision to the document as follows:</p>
                    </div>
                    <div class="panel-body form-group-separated" id="main-panel">
                        @if(isset($referenceDocument))
                        <div class="form-group">
                            <label class="col-md-2 col-xs-5 control-label">Reference Document</label>
                            <div class="col-md-10 col-xs-7">
                                <a href="{{ route('documents.show', $referenceDocument->id) }}" target="_blank" id="#denied_link"><span class="control-label">{{ $referenceDocument->title }}</span></a>
                                <input type="hidden" name="reference_document_id" value="{{ $referenceDocument->id }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 col-xs-5 control-label">Reference Document</label>
                            <div class="col-md-10 col-xs-7">
                                <textarea id="summernote">{{ $referenceDocument->body }}</textarea>
                                <span class="help-block">Highlight the section of the document you are trying to address.</span>
                            </div>
                            @if ($errors->has('referenceDocument'))
                            <span class="help-block successful">
                                <strong class="text-danger">{{ $errors->first('referenceDocument') }}</strong>
                            </span>
                            @endif
                        </div>
                        @endif
                        <div class="form-group">
                            <label class="col-md-2 col-xs-12 control-label">Section / Page / Process</label>
                            <div class="col-md-10 col-xs-12">
                                <input type="text" class="tagsinput" name="reference_document_tags" data-placeholder="add section" value="{{ old('reference_document_tags') }}" id="tags"/>
                                <span class="help-block">Tag the section(s) of the document you are trying to address. e.g. 4.2.3.2</span>
                            </div>
                        </div>
                        <div class="form-group @if($errors->has('attachments')) has-error @endif">
                            <label class="col-md-2 col-xs-5 control-label">Proposed Revision</label>
                            <div class="col-md-10 col-xs-7">
								@if(isset($revisionRequest) && $revisionRequest->proposed_revision <> "<p><br></p>")
									@include('revisionrequests.appeal-elements.old-proposed-revision', ['revisionRequest'])
								@endif <br/><br/>
                                <textarea class="summernote" name="proposed_revision">{{ old('proposed_revision') }}</textarea>
                                <span class="help-block">You may use this editor to submit your revision request or upload a document.</span>
                            </div>
                        </div>
						@if(isset($revisionRequest) && count($revisionRequest->attachments->where('revision_request_id', $revisionRequest->id)) > 0)
							@include('revisionrequests.appeal-elements.old-attachments', ['revisionRequest'])
						@endif
                        <div class="form-group @if($errors->has('attachments')) has-error @endif">
                            <label class="col-md-2 col-xs-5 control-label">Attachments</label>
                            <div class="col-md-10 col-xs-7">
                                <input type="file" multiple id="file-simple" name="attachments[]"/>
								<span class="help-block">
								</span>
                            </div>
                        </div>
						@if(isset($revisionRequest) && $revisionRequest->section_b->recommendation_status == "For Disapproval")
							@include('revisionrequests.appeal-elements.recommendation-reason', ['revisionRequest'])
						@endif
                        <div class="form-group @if($errors->has('revision_reason')) has-error @endif">
                            <label class="col-md-2 col-xs-5 control-label">Reason for Revision</label>
                            <div class="col-md-10 col-xs-7">
                                <textarea class="form-control" rows="5" name="revision_reason" maxlength="600">{{ old('revision_reason') }}</textarea>
                                <span class="help-block">Maximum: 600 characters</span>
								@if ($errors->has('revision_reason'))
								<span class="help-block successful">
									<strong class="text-danger">{{ $errors->first('revision_reason') }}</strong>
								</span>
								@endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 col-xs-5">
                                <button class="btn btn-primary btn-rounded pull-right">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
        <div class="col-md-3" style="position: fixed; top: 12em; right: 1em;">

            <div class="panel panel-default form-horizontal">
                <div class="panel-body">
                    <h3><span class="fa fa-info-circle"></span> Quick Info</h3>
                    <p>Some quick info about this user</p>
                </div>
                <div class="panel-body form-group-separated">
                    <div class="form-group">
                        <label class="col-md-4 col-xs-5 control-label">Full name</label>
                        <div class="col-md-8 col-xs-7 line-height-30">{{ request('user.first_name') }} {{ request('user.last_name') }}</div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 col-xs-5 control-label">Username</label>
                        <div class="col-md-8 col-xs-7 line-height-30">{{ request('user.username') }}</div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 col-xs-5 control-label">Department</label>
                        <div class="col-md-8 col-xs-7">{{ request('user.department') }}</div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 col-xs-5 control-label">Branch</label>
                        <div class="col-md-8 col-xs-7 line-height-30">{{ request('user.branch') }}</div>
                    </div>
                </div>

            </div>

        </div>
    </div>

</div>
@endsection

@section('scripts')
<script type='text/javascript' src={{ url('js/plugins/icheck/icheck.min.js') }}></script>
<script type="text/javascript" src="{{ url('js/plugins/summernote/summernote.js') }}"></script>
<script type="text/javascript" src="{{ url('js/plugins/bootstrap/bootstrap-select.js') }}"></script>
<script type="text/javascript" src="{{ url('js/plugins/fileinput/fileinput.min.js') }}"></script>
<script type="text/javascript" src="{{ url('js/plugins/tagsinput/jquery.tagsinput.min.js') }}"></script>
<script type="text/javascript">
    $(function(){
        $("#file-simple").fileinput({
            showUpload: false,
            showCaption: true,
            uploadUrl: "{{ route('revision-requests.store') }}",
            browseClass: "btn btn-primary",
            browseLabel: "Browse Document",
            allowedFileExtensions : ['.jpg']
        });
    });

    $('#summernote').summernote({
        height: 300,
        toolbar: [
            ['misc', ['fullscreen']],
        ]
    });

	@if(isset($revisionRequest))
		@include('revisionrequests.appeal-elements.denied-request-link', ['revisionRequest'])
	@endif
</script>
@endsection
