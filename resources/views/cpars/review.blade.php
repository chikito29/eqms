@extends('layouts.super-admin')

@section('page-title') Create CPAR | eQMS @stop

@section('nav-audit-findings') active @stop

@section('page-content')
    <div class="page-content-wrap">

        <div class="page-title">
            <h2><span class="fa fa-pencil"></span> CORRECTIVE AND PREVENTIVE ACTION REPORT FORM</h2>
        </div>

        <div class="row">
            <div class="col-md-9">

                <form enctype="multipart/form-data" class="form-horizontal" action="/cpars/review/{{ $cpar->id }}" method="POST" role="form" id="review-form">
                    {{ csrf_field() }}
                    <div class="panel panel-default">
                        <div class="panel-body form-group-separated">
                            <div class="form-group @if($errors->first('cpar-number')) has-error @endif">
                                <label class="col-md-3 col-xs-12 control-label">CPAR Number</label>
                                <div class="col-md-9 col-xs-12">
                                    <input type="text" class="form-control" name="cpar-number" value="{{ old('cpar-number') }}"/>
                                    @if($errors->first('cpar-number')) @component('layouts.error') {{ $errors->first('cpar-number') }} @endcomponent @endif
                                </div>
                            </div>
                            @component('components.show-single-line')
                                @slot('label') Raised By @endslot
                                @foreach($result as $employee)
                                    @if($employee->id == $cpar->raised_by)
                                        {{ $employee->first_name }} {{ $employee->last_name }}
                                    @endif
                                @endforeach
                            @endcomponent
                            @component('components.show-single-line')
                                @slot('label') Department @endslot
                                {{ $cpar->department }}
                            @endcomponent
                            @component('components.show-single-line')
                                @slot('label') Branch @endslot
                                {{ $cpar->branch }}
                            @endcomponent
                            @component('components.show-single-line')
                                @slot('label') Severity Of Findings @endslot
                                {{ strip_tags(str_replace('&nbsp;', '', $cpar->severity)) }}
                            @endcomponent
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Procedure/Process/Scope/Other References</label>
                                <div class="col-md-9 col-xs-12">
                                    <textarea class="summernote" name="proposed_revision" id="summernote" disabled>{!! $documentBody !!}</textarea>
                                    <input type="text" class="hidden" name="reference" value="{{ $cpar->document_id }}">
                                    <input type="text" class="hidden" name="tags" value="{{ $cpar->tags }}">
                                </div>
                            </div>
                            @component('components.show-single-line')
                                @slot('label') Source Of Non-Conformity @endslot
                                {{ $cpar->source }}
                            @endcomponent
                            @if($cpar->other_source)
                                @component('components.show-multi-line')
                                    @slot('label') Others: (Please specify) @endslot
                                    {{ $cpar->other_source }}
                                @endcomponent
                            @endif
                            @component('components.show-multi-line')
                                @slot('label') Details @endslot
                                {{ $cpar->details }}
                            @endcomponent
                            @component('components.show-single-line')
                                @slot('label') Name @endslot
                                @foreach($result as $employee)
                                    @if($employee->id == $cpar->person_reporting)
                                        {{ $employee->first_name }} {{ $employee->last_name }}
                                    @endif
                                @endforeach
                                @slot('help') Person Reporting To Non-Conformity @endslot
                            @endcomponent
                            @component('components.show-single-line')
                                @slot('label') Name @endslot
                                @foreach($result as $employee)
                                    @if($employee->id == $cpar->person_responsible)
                                        {{ $employee->first_name }} {{ $employee->last_name }}
                                    @endif
                                @endforeach
                                @slot('help') Person Responsible For Taking The CPAR @endslot
                            @endcomponent
                            @component('components.show-multi-line')
                                @slot('label') Correction @endslot
                                {{ $cpar->correction }}
                            @endcomponent
                            @component('components.show-multi-line')
                                @slot('label') Root Cause Analysis @endslot
                                {{ $cpar->root_cause }}
                                @slot('help') What Failed In The System To Allow This Non-Conformance To Occur? @endslot
                            @endcomponent
                            @component('components.show-multi-line')
                                @slot('label') Corrective/Preventive Action @endslot
                                {{ $cpar->cp_action }}
                                @slot('help') Specific Details Of Corrective Action Taken To Prevent Recurrence/Occurrence @endslot
                            @endcomponent
                            @component('components.show-single-line')
                                @slot('label') Proposed Corrective Action Complete Date @endslot
                                {{ Carbon\Carbon::parse($cpar->proposed_date)->toFormattedDateString() }}
                            @endcomponent
                            <div class="form-group @if($errors->first('date-completed')) has-error @endif">
                                <label class="col-md-3 col-xs-12 control-label">Corrective/Preventive Complete Date</label>
                                <div class="col-md-9 col-xs-12">
                                    <input type="text" class="form-control datepicker" name="date-completed" value="{{ old('date-completed') }}"/>
                                    @if($errors->first('date-completed')) @component('layouts.error') {{ $errors->first('date_completed') }} @endcomponent @endif
                                </div>
                            </div>
                            @component('components.show-single-line')
                                @slot('label') Department Head @endslot
                                @foreach($result as $employee)
                                    @if($employee->id == $cpar->department_head)
                                        {{ $employee->first_name }} {{ $employee->last_name }}
                                    @endif
                                @endforeach
                            @endcomponent
                            @component('components.show-single-line')
                                @slot('label') Date Confirmed By Department Head @endslot
                                {{ $cpar->date_confirmed }}
                            @endcomponent
                            <div class="form-group">
                                <div class="col-md-12">
                                    <h4><strong>To Be Filled By The QMR / Auditor</strong></h4>
                                </div>
                            </div>
                            <div class="form-group @if($errors->first('cpar-acceptance')) has-error @endif">
                                <label class="col-md-3 col-xs-12 control-label">Acceptance Of CPAR</label>
                                <div class="col-md-9 col-xs-12">
                                    <textarea class="form-control" rows="4" name="cpar-acceptance">{{ $cpar->cpar_acceptance }}</textarea>
                                    @if($errors->first('cpar-acceptance')) @component('layouts.error') {{ $errors->first('cpar-acceptance') }} @endcomponent
                                    @else <span class="help-block">Comments If Any</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group @if($errors->first('date-accepted')) has-error @endif">
                                <label class="col-md-3 col-xs-12 control-label">Date CPAR Accepted</label>
                                <div class="col-md-9 col-xs-12">
                                    <input type="text" class="form-control datepicker" name="date-accepted" value="{{ $cpar->date_accepted }}">
                                    @if($errors->first('date-accepted')) @component('layouts.error') {{ $errors->first('date-accepted') }} @endcomponent @endif
                                </div>
                            </div>
                            <div class="form-group @if($errors->first('verified-by')) has-error @endif">
                                <label class="col-md-3 col-xs-12 control-label">Name</label>
                                <div class="col-md-9 col-xs-12">
                                    <input type="text" class="form-control" name="verified-by"
                                       @foreach($result as $employee)
                                           @if($employee->id == $cpar->verified_by)
                                                value="{{ $employee->first_name }} {{ $employee->last_name }}"
                                           @endif
                                       @endforeach
                                    />
                                    @if($errors->first('verified-by')) @component('layouts.error') {{ $errors->first('verified-by') }} @endcomponent
                                    @else<span class="help-block">QMR / AUDITOR / CEO</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group @if($errors->first('verification-date')) has-error @endif">
                                <label class="col-md-3 col-xs-12 control-label">Verification Date</label>
                                <div class="col-md-9 col-xs-12">
                                    <input type="text" class="form-control datepicker" name="verification-date" value="{{ $cpar->date_verified }}"/>
                                    @if($errors->first('verification-date')) @component('layouts.error') {{ $errors->first('verification-date') }} @endcomponent @endif
                                </div>
                            </div>
                            <div class="form-group @if($errors->first('result')) has-error @endif">
                                <label class="col-md-3 col-xs-5 control-label">Result Of Verification</label>
                                <div class="col-md-9 col-xs-7">
                                    <textarea class="form-control" rows="5" name="result">{{ $cpar->result }}</textarea>
                                    @if($errors->first('result')) @component('layouts.error') {{ $errors->first('result') }} @endcomponent @endif
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
                            <div class="form-group">
                                <div class="col-md-12 col-xs-5">
                                    <button type="button" class="btn btn-primary btn-rounded pull-right" onclick="reviewCpar()">Finalize Review</button>
                                    <button type="button" class="btn btn-info btn-rounded pull-right" onclick="saveAsDraft()">Save Draft</button>
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
@stop

@section('scripts')
    <script type="text/javascript" src="/js/plugins/bootstrap/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="{{ url('js/plugins/summernote/summernote.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/plugins/bootstrap/bootstrap-select.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/plugins/fileinput/fileinput.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/plugins/tagsinput/jquery.tagsinput.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/plugins/summernote/summernote.js') }}"></script>
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

    <script>
        $(function() {
            $('#department').val('{{ $cpar->department }}');
        });

        function reviewCpar() {
            $('#confirmation-modal-trigger').click();
            $('#confirmation-modal-body').html('Finalize CPAR review? This cannot  be undone. If this is unintentional please click Cancel, otherwise, click Okay');
            $('#confirmation-modal-okay-button').attr('onclick', '$(\'#review-form\').submit();');
        }

        function saveAsDraft() {
            $('#review-form').attr('action', '{{ route('cpars.save-as-draft', $cpar->id) }}');
            $('#review-form').submit();
        }
    </script>
@stop

@section('modals')
    <a class="btn btn-primary hidden" data-toggle="modal" href="#confirmation-modal" id="confirmation-modal-trigger">Trigger modal</a>
    <div class="modal fade" id="confirmation-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Confirm action</h4>
                </div>
                <div class="modal-body" id="confirmation-modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmation-modal-okay-button">Okay</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop