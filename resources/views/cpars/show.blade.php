@extends('layouts.super-admin')

@section('page-title')
    Home | Cpar Show
@endsection

@section('nav-audit-findings') active @endsection

@section('page-content')
    <div class="page-content-wrap">

        <div class="page-title">
            <h2><span class="fa fa-pencil"></span> CORRECTIVE AND PREVENTIVE ACTION REPORT FORM</h2>
        </div>

        <div class="row">
            <div class="col-md-9">

                <form class="form-horizontal" role="form" id="form-cpar" action="/action-summary/{{ $cpar->id }}" method="GET" target="_blank">
                    {{ csrf_field() }}
                    <div class="panel panel-default">
                        <div class="panel-body form-group-separated">
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">CPAR Number</label>
                                <div class="col-md-9 col-xs-12">
                                    <label class="form-control">{{ $cpar->cpar_number }}</label>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Raised By</label>
                                <div class="col-md-9 col-xs-12">
                                    <label class="form-control">{{ $cpar->raised_by }}</label>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Department</label>
                                <div class="col-md-9 col-xs-12">
                                    <label class="form-control">{{ $cpar->department }}</label>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Severity Of Findings</label>
                                <div class="col-md-9 col-xs-12">
                                    <label class="form-control">{{ strip_tags(str_replace('&nbsp;', '', $cpar->severity)) }}</label>
                                    <span class="help-block"></span>
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
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-5 control-label">Others: (Please specify)</label>
                                <div class="col-md-9 col-xs-12">
                                    <label class="form-control" style="height: auto;">{!! $cpar->other_source !!}</label>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-5 control-label">Details</label>
                                <div class="col-md-9 col-xs-7">
                                    <label class="form-control" style="height: auto;">{!! $cpar->details !!}</label>
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
                                    <label class="form-control" style="height: auto;">{{ $cpar->person_responsible }}</label>
                                    <span class="help-block">Person Responsible For Taking The CPAR</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-5 control-label">Correction</label>
                                <div class="col-md-9 col-xs-7">
                                    <label class="form-control" style="height: auto;">{{  $cpar->correction }}</label>
                                    <span class="help-block">Action To Eliminate The Detected Non-Conformity</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-5 control-label">Root Cause Analysis</label>
                                <div class="col-md-9 col-xs-7">
                                    <label class="form-control" style="height: auto;">{{  $cpar->root_cause }}</label>
                                    <span class="help-block">What Failed In The System To Allow This Non-Conformance To Occur?</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-5 control-label">Corrective/Preventive Action</label>
                                <div class="col-md-9 col-xs-7">
                                    <label class="form-control" style="height: auto;">{{ $cpar->cp_action }}</label>
                                    <span class="help-block">Specific Details Of Corrective Action Taken To Prevent Recurrence/Occurrence</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Proposed Corrective Action Complete Date</label>
                                <div class="col-md-9 col-xs-12">
                                    <label class="form-control">{{ $cpar->proposed_date }}</label>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Corrective/Preventive Complete Date</label>
                                <div class="col-md-9 col-xs-12">
                                    <label class="form-control">{{ $cpar->date_completed }}</label>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Department Head</label>
                                <div class="col-md-9 col-xs-12">
                                    <label class="form-control">{{ $cpar->department_head }}</label>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Date Confirmed By Department Head</label>
                                <div class="col-md-9 col-xs-12">
                                    <label class="form-control" style="height: auto;">{{ $cpar->date_confirmed_by }}</label>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <h4><strong>To Be Filled By The QMR / Auditor</strong></h4>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Acceptance Of CPAR</label>
                                <div class="col-md-9 col-xs-12">
                                    <label class="form-control" style="height: auto;">{{ $cpar->acceptance }}</label>
                                    <span class="help-block">Comments If Any</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Date CPAR Accepted</label>
                                <div class="col-md-9 col-xs-12">
                                    <label class="form-control">{{ $cpar->date_accepted }}</label>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Name</label>
                                <div class="col-md-9 col-xs-12">
                                    <label class="form-control">{{ $cpar->date_confirmed_by }}</label>
                                    <span class="help-block">QMR / AUDITOR / CEO</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Verification Date</label>
                                <div class="col-md-9 col-xs-12">
                                    <label class="form-control">{{ $cpar->date_verified }}</label>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Verified By</label>
                                <div class="col-md-9 col-xs-12">
                                    <label class="form-control" style="height: auto;">{{ $cpar->verified_by }}</label>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-5 control-label">Result Of Verification</label>
                                <div class="col-md-9 col-xs-7">
                                    <label class="form-control" style="height: auto;">{{ $cpar->result }}</label>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-5 control-label">Attachments</label>
                                <div class="col-md-9 col-xs-7">
                                    <li class="list-unstyled">
                                        @if($cpar->attachments->count() > 0)
                                            <ul>asdasdasd</ul>
                                        @else
                                            No Attachment Avaible For This CPAR
                                        @endif
                                    </li>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <button type="button" class="btn btn-primary btn-rounded pull-right" onclick="printCpar()">Print CPAR</button>
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
@stop

@section('scripts')
    <script type="text/javascript" src="{{ url('js/plugins/summernote/summernote.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/plugins/bootstrap/bootstrap-select.js') }}"></script>
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
                ['misc', ['fullscreen']]
            ],
        });

        function printCpar() {
            $('#form-cpar').submit();
        }
    </script>
@stop