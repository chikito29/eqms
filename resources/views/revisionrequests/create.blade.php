@extends('layouts.main')

@section('page-title')New Revision Request | eQMS @endsection

@section('nav-actions') active @endsection

@section('page-content')
<div class="page-content-wrap">

    <div class="page-title">
        <h2><span class="fa fa-pencil"></span> Revision Request</h2>
    </div>

    <div class="row">
        <div class="col-md-9">

            <form enctype="multipart/form-data" class="form-horizontal" action="{{ route('revision-requests.store') }}" method="POST" role="form">
                {{ csrf_field() }}
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3>Section A: Formal Request</h3>
                        <p>This is to formalize a request for a revision to the document as follows:</p>
                    </div>
                    <div class="panel-body form-group-separated">
                        @if(isset($referenceDocument))
                        <div class="form-group">
                            <label class="col-md-2 col-xs-5 control-label">Reference Document</label>
                            <div class="col-md-10 col-xs-7">
                                <a href="{{ route('documents.show', $referenceDocument->id) }}" target="_blank"><label class="control-label">{{ $referenceDocument->title }}</label></a>
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
                                <input type="text" class="tagsinput" name="reference_document_tags" data-placeholder="add section"/>
                                <span class="help-block">Tag the section(s) of the document you are trying to address. e.g. 4.2.3.2</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 col-xs-5 control-label">Proposed Revision</label>
                            <div class="col-md-10 col-xs-7">
                                <textarea class="summernote" name="proposed_revision"></textarea>
                                <span class="help-block">You may use this editor to submit your revision request or upload a document.</span>
                            </div>
                            @if ($errors->has('proposed_revision'))
                            <span class="help-block successful">
                                <strong class="text-danger">{{ $errors->first('proposed_revision') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 col-xs-5 control-label">Attachments</label>
                            <div class="col-md-10 col-xs-7">
                                <input type="file" multiple id="file-simple" name="attachments[]"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 col-xs-5 control-label">Reason for Revision</label>
                            <div class="col-md-10 col-xs-7">
                                <textarea class="form-control" rows="5" name="revision_reason" maxlength="600"></textarea>
                                <span class="help-block">Maximum: 600 characters</span>
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
        <div class="col-md-3">

            <div class="panel panel-primary">
                <div class="panel-body">
                    <h3>Search</h3>
                    <form id="faqForm">
                        <div class="input-group">
                            <input type="text" class="form-control" id="faqSearchKeyword" placeholder="Search..."/>
                            <div class="input-group-btn">
                                <button class="btn btn-primary" id="faqSearch">Search</button>
                            </div>
                        </div>
                    </form>
                    <div class="push-up-10"><strong>Search Result:</strong> <span id="faqSearchResult">Please fill keyword field</span></div>
                    <div class="push-up-10">
                        <button class="btn btn-primary" id="faqRemoveHighlights">Remove Highlights</button>
                        <div class="pull-right">
                            <button class="btn btn-default" id="faqOpenAll"><span class="fa fa-angle-down"></span> Open All</button>
                            <button class="btn btn-default" id="faqCloseAll"><span class="fa fa-angle-up"></span> Close All</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-primary">
                <div class="panel-body">
                    <h3>Contact</h3>
                    <p>Feel free to contact us for any issues you might have with our products.</p>
                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="email" class="form-control" placeholder="youremail@domain.com">
                    </div>
                    <div class="form-group">
                        <label>Subject</label>
                        <input type="email" class="form-control" placeholder="Message subject">
                    </div>
                    <div class="form-group">
                        <label>Message</label>
                        <textarea class="form-control" placeholder="Your message" rows="3"></textarea>
                    </div>
                </div>
                <div class="panel-footer">
                    <button class="btn btn-default"><span class="fa fa-paperclip"></span> Add attachment</button>
                    <button class="btn btn-success pull-right"><span class="fa fa-envelope-o"></span> Send</button>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection

@section('scripts')
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
</script>
@endsection
