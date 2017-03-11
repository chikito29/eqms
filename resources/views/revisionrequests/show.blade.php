@extends('layouts.super-admin')

@section('page-title')Revision Request |eQMS @endsection

@section('nav-actions') active @endsection

@section('page-content')
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="page-title">
        <h2><span class="fa fa-pencil"></span> Revision Request</h2>
    </div>

    <div class="row">
        <div class="col-md-9">

            <!-- Start Section A -->
            <form class="form-horizontal">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3>Section A: Formal Request</h3>
                        <p>This is to formalize a request for a revision to the document as follows:</p>
                    </div>
                    <div class="panel-body form-group-separated">
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">Revision Request No.</label>
                            <div class="col-md-9 col-xs-7">
                                <label class="control-label">NCPI-QMR-2001-24</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">Date Submitted</label>
                            <div class="col-md-9 col-xs-7">
                                <label class="control-label">{{ $revisionRequest->created_at->toFormattedDateString() }}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">Reference Document</label>
                            <div class="col-md-9 col-xs-7">
                                <a href="{{ route('documents.show', $revisionRequest->reference_document->id) }}" target="_blank"><label class="control-label">{{ $revisionRequest->reference_document->title }} <span class="fa fa-external-link"></span></label></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Section / Page / Process</label>
                            <div class="col-md-9 col-xs-12">
                                <ul class="list-tags">
                                    @foreach(explode( ',', $revisionRequest->reference_document_tags ) as $reference_document_tags)
                                        <li><a href="#">{{ $reference_document_tags }}</a></li>
                                    @endforeach
                                </ul>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">Attachments</label>
                            <div class="col-md-9 col-xs-7">
                                @if(count($revisionRequest->attachments->where('section', 'revision-request-a')) > 0)
                                    @foreach($revisionRequest->attachments->where('section', 'revision-request-a') as $attachment)
                                        <a href="{{ url($attachment->file_path) }}" target="_blank"><label class="control-label">{{ $attachment->file_name }}</label></a><br>
                                    @endforeach
                                @else
                                    <label class="control-label">None</label>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Reason for Revision</label>
                            <div class="col-md-9 col-xs-12">
                                <div class="panel-body" style="background-color: rgb(249,249,249); padding: 20px; border-radius: 5px;">
                                    {{ $revisionRequest->revision_reason }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Proposed Revision</label>
                            <div class="col-md-9 col-xs-12">

                                <div class="panel-body" style="background-color: rgb(249,249,249); padding: 20px; border-radius: 5px;">
                                    {!! $revisionRequest->proposed_revision !!}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
            <!-- End Section A -->

            <!-- Start Section B -->
            <form enctype="multipart/form-data" class="form-horizontal" action="{{ route('revision-requests.update', $revisionRequest->id) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('put') }}
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3>Section B: QMR's Recommendation</h3>
                        @if($revisionRequest->section_b)
                        <p>{{ $revisionRequest->section_b->created_at->toDayDateTimeString() }}</p>
                        @else
                        <p>For Approval/Disapproval</p>
                        @endif
                    </div>
                    <div class="panel-body form-group-separated">
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">Recommendation Status</label>
                            <div class="col-md-9 col-xs-7">
                                @if( ! $revisionRequest->section_b)
                                <select class="form-control select" name="recommendation_status">
                                    <option>For Approval</option>
                                    <option>Denied</option>
                                </select>
                                @else
                                    @if($revisionRequest->section_b->recommendation_status == 'For Approval')
                                    <label class="control-label"><span class="label label-success label-form" style="color: white;">{{ $revisionRequest->section_b->recommendation_status }}</span></label>
                                    @else
                                    <label class="control-label"><span class="label label-danger label-form" style="color: white;">{{ $revisionRequest->section_b->recommendation_status }}</span></label>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">Reason for Recommendation / Disapproval</label>
                            <div class="col-md-9 col-xs-7">
                                @if( ! $revisionRequest->section_b)
                                <textarea class="form-control" rows="5" name="recommendation_reason"></textarea>
                                @else
                                <div class="panel-body" style="background-color: rgb(249,249,249); padding: 20px; border-radius: 5px;">
                                    {{ $revisionRequest->section_b->recommendation_reason }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 col-xs-12">
                                @if( ! $revisionRequest->section_b)
                                <button class="btn btn-primary btn-rounded pull-right">Submit</button>
                                @else
                                <a href="http://google.com/" class="btn btn-info btn-rounded pull-right" target="_blank"><span class="fa fa-print"></span> Print</a>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- End Section B -->

            <!-- Start Section C -->
            @if($revisionRequest->section_b)
            @if($revisionRequest->section_b->recommendation_status == 'For Approval')
            <form enctype="multipart/form-data" class="form-horizontal" action="{{ route('revision-requests.update', $revisionRequest->id) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('put') }}
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3>Section C: Approval/Disapproval</h3>
                        @if($revisionRequest->section_c)
                        <p>{{ $revisionRequest->section_c->created_at->toDayDateTimeString() }}</p>
                        @else
                        <p>For Approval/Disapproval</p>
                        @endif
                    </div>
                    <div class="panel-body form-group-separated">
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">CEO Approval Status</label>
                            <div class="col-md-9 col-xs-7">
                                @if( ! $revisionRequest->section_c)
                                <select class="form-control select" name="approved">
                                    <option value=1>Approved</option>
                                    <option value=0>Denied</option>
                                </select>
                                @else
                                    @if($revisionRequest->section_c->approved == true)
                                    <label class="control-label"><span class="label label-success label-form" style="color: white;">Approved</span></label>
                                    @else
                                    <label class="control-label"><span class="label label-danger label-form" style="color: white;">Denied</span></label>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">Attachment</label>
                            <div class="col-md-9 col-xs-7">
                                @if( ! $revisionRequest->section_c)
                                <input type="file" multiple id="file-simple" name="attachments[]"/>
                                <span class="help-block">Upload the signed revision request by the CEO.</span>
                                @else
                                    @if(count($revisionRequest->attachments->where('section', 'revision-request-c')) > 0)
                                        @foreach($revisionRequest->attachments->where('section', 'revision-request-c') as $attachment)
                                            <a href="{{ url($attachment->file_path) }}" target="_blank"><label class="control-label">{{ $attachment->file_name }}</label></a><br>
                                        @endforeach
                                    @else
                                        <label class="control-label">None</label>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">Remarks</label>
                            <div class="col-md-9 col-xs-7">
                                @if( ! $revisionRequest->section_c)
                                <textarea class="form-control" rows="5" name="ceo_remarks"></textarea>
                                @else
                                <div class="panel-body" style="background-color: rgb(249,249,249); padding: 20px; border-radius: 5px;">
                                    {{ $revisionRequest->section_c->ceo_remarks }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 col-xs-5">
                                @if( ! $revisionRequest->section_c)
                                <button class="btn btn-primary btn-rounded pull-right">Submit</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @endif
            @endif
            <!-- End Section C -->

            <!-- Start Section D -->
            @if($revisionRequest->section_b && $revisionRequest->section_c)
            @if($revisionRequest->section_c->approved)
            <form enctype="multipart/form-data" class="form-horizontal" action="{{ route('revision-requests.update', $revisionRequest->id) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('put') }}
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3>Section D: Action Taken</h3>
                        @if($revisionRequest->section_b)
                        <p>{{ $revisionRequest->section_b->created_at->toDayDateTimeString() }}</p>
                        @endif
                    </div>
                    <div class="panel-body form-group-separated">
                        <div class="form-group">
                            <label class="col-md-3 col-xs-7 control-label">Action Taken</label>
                            <div class="col-md-9 col-xs-5">
                                @if( ! $revisionRequest->section_d)
                                <select class="form-control select" name="action_taken">
                                    <option value="Document Revised">Document Revised</option>
                                    <option value="Updated">Updated</option>
                                    <option value="Distributed to Holders">Distributed to Holders</option>
                                    <option value="Distributed to Holders">Others</option>
                                </select>
                                @else
                                    @if($revisionRequest->section_d->action_taken != 'Others')
                                    <label class="control-label">{{ $revisionRequest->section_d->action_taken }}</label>
                                    @else
                                    <div class="panel-body" style="background-color: rgb(249,249,249); padding: 20px; border-radius: 5px;">
                                        {{ $revisionRequest->section_d->others }}
                                    </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                        @if( ! $revisionRequest->section_d)
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">If others, please specify</label>
                            <div class="col-md-9 col-xs-7">
                                <textarea class="form-control" rows="5" name="others"></textarea>
                            </div>
                        </div>
                        @endif
                        <div class="form-group">
                            <div class="col-md-12 col-xs-5">
                                @if( ! $revisionRequest->section_d)
                                <button class="btn btn-primary btn-rounded pull-right">Submit</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @endif
            @endif
            <!-- End Section D -->

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
<!-- END PAGE CONTENT WRAPPER -->
@endsection

@section('scripts')
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

        function print() {
            // var form = $("#form-filter");
            // form.attr({
            //     "action": "http://mbhs.dev/reports/print/student-enrollment",
            //     "target": "_blank"
            // });
            // form.submit();
            // form.attr("action", "http://mbhs.dev/reports/student-enrollment");
            // form.removeAttr("target");

        }

    });
</script>
@endsection
