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

                        <form class="form-horizontal" role="form" action="/answer/{{ $cpar->id }}" method="POST" id="form-cpar">
                            {{ csrf_field() }}
                            <div class="panel panel-default">
                                <div class="panel-body form-group-separated">
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">CPAR Number</label>
                                        <div class="col-md-9 col-xs-12">
                                            <label class="form-control">{{ $cpar->cpar_number }}</label>
                                        </div>
                                    </div>
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
                                            <label class="form-control" style="display: block; height: auto;">{!! $cpar->other_source !!}</label>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-5 control-label">Details</label>
                                        <div class="col-md-9 col-xs-7">
                                            <label class="form-control" style="display: block; height: auto;">{!! $cpar->details !!}</label>
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
                                            <textarea class="form-control" rows="10" name="correction" required>{{  old('correction') }}</textarea>
                                            @if($errors->first('correction')) <span class="text text-danger">{{ $errors->first('correction') }}</span>
                                            @else <span class="help-block">Action To Eliminate The Detected Non-Conformity</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-5 control-label">Root Cause Analysis</label>
                                        <div class="col-md-9 col-xs-7">
                                            <label class="form-control" style="display: block; height: auto;">{{  $cpar->root_cause }}</label>
                                            <span class="help-block">What Failed In The System To Allow This Non-Conformance To Occur?</span>
                                        </div>
                                    </div>
                                    <div class="form-group @if($errors->first('cp-action')) has-error @endif">
                                        <label class="col-md-3 col-xs-5 control-label">Corrective/Preventive Action</label>
                                        <div class="col-md-9 col-xs-7">
                                            <textarea class="form-control" rows="10" name="cp-action" required>{{ old('cp-action') }}</textarea>
                                            @if($errors->first('cp-action')) <span class="text text-danger">{{ $errors->first('cp-action') }}</span>
                                            @else <span class="help-block">Specific Details Of Corrective Action Taken To Prevent Recurrence/Occurrence</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group @if($errors->first('proposed-date')) has-error @endif">
                                        <label class="col-md-3 col-xs-12 control-label">Proposed Corrective Action Complete Date</label>
                                        <div class="col-md-9 col-xs-12">
                                            <input type="text" class="form-control datepicker" name="proposed-date" value="{{ old('proposed-date') }}" id="proposed-date" required/>
                                            @if($errors->first('proposed-date')) <span class="text text-danger">{{ $errors->first('proposed-date') }}</span>
                                            @endif
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
                                    <div class="form-group">
                                        <div class="col-md-12 col-xs-5">
                                            <button class="btn btn-primary btn-rounded pull-right" onclick="$('#attention-modal-trigger').click()">Submit</button>
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
                <p>You are given 10 working days(Saturdays included) to answer.</p>
                <p>Due date of answering this CPAR is at the end of <strong class="text text-danger">{{ $dueDate->toFormattedDateString() }}</strong>.</p>
                <p>You still have <strong class="text text-success">{{ Carbon\Carbon::now()->diffInDays($dueDate, false) }}</strong> remaining day/s to comply.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<a class="mb-control" data-box="#mb-confirm" href="#mb-confirm" id="attention-modal-trigger">Trigger </a>
<!-- MESSAGE BOX-->
<div class="message-box animated fadeIn" data-sound="alert" id="mb-confirm">
    <div class="mb-container">
        <div class="mb-middle">
            <div class="mb-title"><span class="fa fa-exclamation-triangle"></span><strong>Send this CPAR for Review</strong>?</div>
            <div class="mb-content">
                <p>Clicking <em>Yes</em> will send this CPAR on QMR for review.</p>
                <p>By this time, you cannot view or change this CPAR, unless asked to do so.</p>
                <p>Please confirm your action.</p>
            </div>
            <div class="mb-footer">
                <div class="pull-right">
                    <a onclick="submitCpar()" class="btn btn-success btn-lg">Yes</a>
                    <button class="btn btn-default btn-lg mb-control-close">No</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END MESSAGE BOX-->

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
<script type="text/javascript" src="{{ url('js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js') }}"></script>
<script type="text/javascript" src="{{ url('js/plugins/scrolltotop/scrolltopcontrol.js') }}"></script>
<script type='text/javascript' src="{{ url('js/plugins/noty/jquery.noty.js') }}"></script>
<script type='text/javascript' src="{{ url('js/plugins/noty/layouts/topRight.js') }}"></script>
<script type='text/javascript' src="{{ url('js/plugins/noty/themes/default.js') }}"></script>
<script type="text/javascript" src="{{ url('js/plugins/summernote/summernote.js') }}"></script>
<script type="text/javascript" src="{{ url('js/plugins/bootstrap/bootstrap-select.js') }}"></script>
<script type="text/javascript" src="{{ url('js/plugins/bootstrap/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript">
    $(function(){
        @if($notify = session('notify'))
            noty({text: '{{ $notify['message'] }}', layout: 'topRight', type: '{{ $notify['type'] }}'});
        @endif

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
<!-- END THIS PAGE PLUGINS-->

<!-- START TEMPLATE -->
<script type="text/javascript" src="{{ url('js/plugins.js') }}"></script>
<script type="text/javascript" src="{{ url('js/actions.js') }}"></script>
<!-- END TEMPLATE -->
<!-- END SCRIPTS -->
</body>
</html>
