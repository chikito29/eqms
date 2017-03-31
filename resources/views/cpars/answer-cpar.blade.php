<!DOCTYPE html>
<html lang="en">
<head>
    <!-- META SECTION -->
    <title>eQMS | Answer CPAR</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="icon" href="{{ url('favicon.ico') }}" type="image/x-icon" />
    <!-- END META SECTION -->

    <!-- CSS INCLUDE -->
    <link rel="stylesheet" type="text/css" id="theme" href="{{ url('css/theme-default.css') }}"/>

<!-- EOF CSS INCLUDE -->
</head>
<body class="x-dashboard">
<!-- START PAGE CONTAINER -->
<div class="page-container">
    <!-- PAGE CONTENT -->
    <div class="page-content">
        <!-- PAGE CONTENT WRAPPER -->
        <div class="page-content-wrap">

            @include('layouts.answer-cpar-nav')

            <div class="page-content-wrap">

                <div class="page-title">
                    <h2><span class="fa fa-pencil"></span> CORRECTIVE AND PREVENTIVE ACTION REPORT FORM</h2>
                </div>

                <div class="row">
                    <div class="col-md-12">

                        <form class="form-horizontal" role="form" action="/answer/{{ $cpar->id }}" method="POST" id="form-cpar" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="panel panel-default">
                                <div class="panel-body form-group-separated">
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Raised By</label>
                                        <div class="col-md-9 col-xs-12">
                                            <label class="form-control">{{ $cpar->raised_by }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Department</label>
                                        <div class="col-md-9 col-xs-12">
                                            <label class="form-control">{{ $cpar->department }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Severity Of Findings</label>
                                        <div class="col-md-9 col-xs-12">
                                            <label class="form-control">{{ strip_tags(str_replace('&nbsp;', '', $cpar->severity)) }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Procedure/Process/Scope/Other References</label>
                                        <div class="col-md-9 col-xs-12">
                                            <textarea class="summernote" name="proposed_revision" id="summernote" disabled>{!! $documentBody !!}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Source Of Non-Comformity</label>
                                        <div class="col-md-9 col-xs-12">
                                            <label class="form-control">{{ $cpar->source }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-5 control-label">Others: (Please specify)</label>
                                        <div class="col-md-9 col-xs-12">
                                            <div class="panel-body" style="background-color: rgb(249,249,249); padding: 20px; border-radius: 5px;">
                                                {!! $cpar->other_source !!}
                                            </div>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-5 control-label">Details</label>
                                        <div class="col-md-9 col-xs-7">
                                            <div class="panel-body" style="background-color: rgb(249,249,249); padding: 20px; border-radius: 5px;">
                                                {!! $cpar->details !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Name</label>
                                        <div class="col-md-9 col-xs-12">
                                            <label class="form-control">{{ $cpar->person_reporting }}</label>
                                            <span class="help-block">Person Reporting To Non-Conformity</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Name</label>
                                        <div class="col-md-9 col-xs-12">
                                            <label class="form-control">{{ $cpar->person_responsible }}</label>
                                            <span class="help-block">Person Responsible For Taking The CPAR</span>
                                        </div>
                                    </div>
                                    <div class="form-group @if($errors->first('correction')) has-error @endif">
                                        <label class="col-md-3 col-xs-5 control-label">Correction</label>
                                        <div class="col-md-9 col-xs-7">
                                            <textarea class="form-control" rows="10" name="correction" required>{{  old('correction') }}{{ $cpar->correction }}</textarea>
                                            @if($errors->first('correction')) <span class="text text-danger">{{ $errors->first('correction') }}</span>
                                            @else <span class="help-block">Action To Eliminate The Detected Non-Conformity</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group  @if($errors->first('root-cause')) has-error @endif">
                                        <label class="col-md-3 col-xs-5 control-label">Root Cause Analysis</label>
                                        <div class="col-md-9 col-xs-7">
                                            <textarea class="form-control" rows="10" name="root-cause" required>{{  old('root-cause') }}{{ $cpar->root_cause }}</textarea>
                                            @if($errors->first('root-cause')) <span class="text text-danger">{{ $errors->first('root-cause') }}</span>
                                            @else <span class="help-block">What Failed In The System To Allow This Non-Conformance To Occur?</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group @if($errors->first('cp-action')) has-error @endif">
                                        <label class="col-md-3 col-xs-5 control-label">Corrective/Preventive Action</label>
                                        <div class="col-md-9 col-xs-7">
                                            <textarea class="form-control" rows="10" name="cp-action" required>{{ old('cp-action') }}{{ $cpar->cp_action }}</textarea>
                                            @if($errors->first('cp-action')) <span class="text text-danger">{{ $errors->first('cp-action') }}</span>
                                            @else <span class="help-block">Specific Details Of Corrective Action Taken To Prevent Recurrence/Occurrence</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group @if($errors->first('proposed-date')) has-error @endif">
                                        <label class="col-md-3 col-xs-12 control-label">Proposed Corrective Action Complete Date</label>
                                        <div class="col-md-9 col-xs-12">
                                            <label class="form-control">{{ $cpar->proposed_date }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Corrective/Preventive Complete Date</label>
                                        <div class="col-md-9 col-xs-12">
                                            <input type="text" class="form-control datepicker" disabled="disabled" value="{{ $cpar->date_completed }}"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Department Head</label>
                                        <div class="col-md-9 col-xs-12">
                                            <label class="form-control">{{ $cpar->department_head }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Date Confirmed By Department Head</label>
                                        <div class="col-md-9 col-xs-12">
                                            <input type="text" class="form-control" disabled="disabled" value="{{ $cpar->date_confirmed_by }}"/>
                                        </div>
                                    </div>
                                    <div class="form-group @if(request('user.first_name') <> $cpar->person_responsible) hidden @endif">
                                        <label class="col-md-3 col-xs-5 control-label">Attachment</label>
                                        <div class="col-md-9 col-xs-7">
                                            <input type="file" multiple id="file-simple" name="attachments[]"/>
                                            <span class="help-block">Attach document / scanned document if needed.</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-xs-5">
                                            <button type="button" class="btn btn-primary btn-rounded pull-right" onclick="$('#attention-modal-trigger').click()" >Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

            </div>

            <div class="footer x-content-footer no-print">
                Copyright © 2017 NEWSIM. All rights reserved
            </div>

        </div>
        <!-- END PAGE CONTENT WRAPPER -->
    </div>
    <!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->

<!-- MESSAGE BOX-->
<div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
    <div class="mb-container">
        <div class="mb-middle">
            <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
            <div class="mb-content">
                <p>Are you sure you want to log out?</p>
                <p>Press No if you want to continue work. Press Yes to logout current user.</p>
            </div>
            <div class="mb-footer">
                <div class="pull-right">
                    <a href="pages-login.html" class="btn btn-success btn-lg">Yes</a>
                    <button class="btn btn-default btn-lg mb-control-close">No</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END MESSAGE BOX-->

<div class="modal fade" id="attention-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><strong class="text text-warning">ATTENTION</strong></h4>
            </div>
            <div class="modal-body">
                <p>This CPAR has been issued <strong class="text text-info">{{ $cpar->created_at->toDayDateTimeString() }}</strong>.</p>
                <p>You are given {{ $due }} working day/s (Saturdays included) to answer.</p>
                <p>Due date of answering this CPAR is at the end of <strong class="text text-danger">{{ $dueDate->toFormattedDateString() }}</strong>.</p>
                @if(\Carbon\Carbon::parse($cpar->proposed_date)->startOfDay()->eq(\Carbon\Carbon::now()->startOfDay())) <p>You still have <strong class="text text-success">{{ 24 - Carbon\Carbon::now()->hour }}</strong> remaining working hour/s to comply.</p>
                @else <p>You still have <strong class="text text-success">{{ $cpar->created_at->diffInDays($dueDate) }}</strong> remaining working day/s to comply.</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<a class="btn btn-primary hidden" data-toggle="modal" href="#modal-id" id="attention-modal-trigger">Trigger modal</a>
<div class="modal fade" id="modal-id">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><strong>Send this CPAR for Review</strong>?</h4>
            </div>
            <div class="modal-body">
                <p>Clicking <em>Yes</em> will send this CPAR on QMR for review.</p>
                <p>By this time, you cannot view or change this CPAR, unless asked to do so.</p>
                <p>Please confirm your action.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal">No</button>
                <button onclick="submitCpar()" class="btn btn-success">Yes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- START PRELOADS -->
<audio id="audio-alert" src="{{ url('audio/alert.mp3') }}" preload="auto"></audio>
<audio id="audio-fail" src="{{ url('audio/fail.mp3') }}" preload="auto"></audio>
<!-- END PRELOADS -->

<!-- START SCRIPTS -->
<!-- START PLUGINS -->
<script type="text/javascript" src="{{ url('js/plugins/jquery/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ url('js/plugins/jquery/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ url('js/plugins/bootstrap/bootstrap.min.js') }}"></script>
<!-- END PLUGINS -->

<!-- START THIS PAGE PLUGINS-->
<script type="text/javascript" src="/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
<script type="text/javascript" src="/js/plugins/summernote/summernote.js"></script>
<script type="text/javascript" src="/js/plugins/bootstrap/bootstrap-select.js"></script>
<script type="text/javascript" src="/js/plugins/fileinput/fileinput.min.js"></script>
<script type="text/javascript" src="/js/plugins/tagsinput/jquery.tagsinput.min.js"></script>
<script type="text/javascript">
    $(function(){
        @if($cpar->cparAnswered->status == 1) $('li.active').empty().append("<a>Editing CPAR | Already answered <span class=\"text text-info\">{{ $cpar->cparAnswered->created_at->diffForHumans() }}</span></a>");
        @else $('#attention-modal').modal('toggle');
        @endif
    });

    $('#summernote').summernote({
        height: 300,
        toolbar: [
            ['misc', ['fullscreen']]
        ],
    });

    function submitCpar() {
        $('#form-cpar').submit();
    }
</script>

<script>
    $(function(){
        $("#file-simple").fileinput({
            showUpload: false,
            showCaption: true,
            browseClass: "btn btn-primary",
            browseLabel: "Browse Document",
            allowedFileExtensions : ['.jpg']
        });
    });
</script>
<!-- END THIS PAGE PLUGINS-->
@yield('scripts')
<!-- START TEMPLATE -->
<script type="text/javascript" src="{{ url('js/plugins.js') }}"></script>
<script type="text/javascript" src="{{ url('js/actions.js') }}"></script>
<!-- END TEMPLATE -->
<!-- END SCRIPTS -->
</body>
</html>
