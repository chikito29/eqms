@extends('layouts.main')

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
                            @component('components.show-single-line')
                                @slot('label') Raised By @endslot
                                @foreach($employees as $employee)
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
                                    <textarea class="summernote" name="proposed_revision" id="summernote" disabled>{!! $body !!}</textarea>
                                </div>
                            </div>
                            @component('components.show-single-line')
                                @slot('label') Tags @endslot
                                @foreach(explode(',', $cpar->tags) as $tag)
                                    <span style="border: solid 1px; border-color: rgb(220,220,220); padding: 4px 13px; border-radius: 3px; background-color: rgb(250,250,250);"><span class="fa fa-tag"> {{ $tag }}</span></span>
                                @endforeach
                            @endcomponent
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
                                @foreach($employees as $employee)
                                    @if($employee->id == $cpar->person_reporting)
                                        {{ $employee->first_name }} {{ $employee->last_name }}
                                    @endif
                                @endforeach
                                @slot('help') Person Reporting To Non-Conformity @endslot
                            @endcomponent
                            @component('components.show-single-line')
                                @slot('label') Name @endslot
                                @foreach($employees as $employee)
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
                            <div class="form-group @if($errors->first('date_completed')) has-error @endif">
                                <label class="col-md-3 col-xs-12 control-label">Corrective/Preventive Complete Date</label>
                                <div class="col-md-9 col-xs-12">
                                    <input type="text" class="form-control datepicker" name="date_completed" value="{{ $cpar->date_completed }}"/>
                                    @if($errors->first('date_completed')) @component('layouts.error') {{ $errors->first('date_completed') }} @endcomponent @endif
                                </div>
                            </div>
                            @component('components.show-single-line')
                                @slot('label') Department Head @endslot
                                @foreach($employees as $employee)
                                    @if($employee->id == $cpar->chief)
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
                                    <textarea class="form-control" rows="4" name="cpar_acceptance">{{ $cpar->cpar_acceptance }}</textarea>
                                    @if($errors->first('cpar_acceptance')) @component('layouts.error') {{ $errors->first('cpar_acceptance') }} @endcomponent
                                    @else <span class="help-block">Comments If Any</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group @if($errors->first('date-accepted')) has-error @endif">
                                <label class="col-md-3 col-xs-12 control-label">Date CPAR Accepted</label>
                                <div class="col-md-9 col-xs-12">
                                    <input type="text" class="form-control datepicker" name="date_accepted" value="{{ $cpar->date_accepted }}">
                                    @if($errors->first('date_accepted')) @component('layouts.error') {{ $errors->first('date_accepted') }} @endcomponent @endif
                                </div>
                            </div>
                            <div class="form-group @if($errors->first('verified-by')) has-error @endif">
                                <label class="col-md-3 col-xs-12 control-label">Name</label>
                                <div class="col-md-9 col-xs-12">
                                    <input type="text" class="form-control" name="verified_by"
                                       @foreach($employees as $employee)
                                           @if($employee->id == $cpar->verified_by)
                                                value="{{ $employee->first_name }} {{ $employee->last_name }}"
                                           @endif
                                       @endforeach
                                    />
                                    @if($errors->first('verified_by')) @component('layouts.error') {{ $errors->first('verified_by') }} @endcomponent
                                    @else<span class="help-block">QMR / AUDITOR / CEO</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group @if($errors->first('verification-date')) has-error @endif">
                                <label class="col-md-3 col-xs-12 control-label">Verification Date</label>
                                <div class="col-md-9 col-xs-12">
                                    <input type="text" class="form-control datepicker" name="verification_date" value="{{ $cpar->date_verified }}"/>
                                    @if($errors->first('verification_date')) @component('layouts.error') {{ $errors->first('verification_date') }} @endcomponent @endif
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
                                <label class="col-md-3 col-xs-5 control-label">Add Attachment/s</label>
                                <div class="col-md-9 col-xs-7">
                                    <input type="file" multiple id="file-simple" name="attachments[]"/>
                                    <span class="help-block">Attach document / scanned document if needed.</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-5 control-label">Attachment/s</label>
                                <div class="col-md-9 col-xs-7">
									<div class="gallery" id="links">
										@if($cpar->attachments->count() > 0)
											@foreach($cpar->attachments as $attachment)
													<a class="gallery-item" href="{{ asset($attachment->file_path) }}">
														<div class="image">
															<img src="{{ asset($attachment->file_path) }}"/>
														</div>
														<div class="meta">
															<strong>{{  $attachment->file_name }}</strong>
															<span>added by {{ $attachment->uploaded_by }}</span>
														</div>
													</a>
											@endforeach
										@else
											No Attachment Avaible For This CPAR
										@endif
									</div>
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

                <div class="panel panel-default form-horizontal">
                    <div class="panel-body">
                        <h3><span class="fa fa-info-circle"></span> Quick Info</h3>
                        <p>Some quick info about this user</p>
                    </div>
                    <div class="panel-body form-group-separated">
                        <div class="form-group">
                            <label class="col-md-4 col-xs-5 control-label">Role</label>
                            <div class="col-md-8 col-xs-7 line-height-30">{{ request('user.role') }}</div>
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
@stop

@section('scripts')
    <script type="text/javascript" src="/js/plugins/bootstrap/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="{{ url('js/plugins/summernote/summernote.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/plugins/bootstrap/bootstrap-select.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/plugins/fileinput/fileinput.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/plugins/tagsinput/jquery.tagsinput.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/plugins/summernote/summernote.js') }}"></script>
	<script type="text/javascript" src="{{ url('js/plugins/blueimp/jquery.blueimp-gallery.min.js') }}"></script>
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
            $('#confirmation-modal-trigger').click();
            $('#confirmation-modal-body').html('Attachments will not be saved when saving CPAR as draft.');
            $('#confirmation-modal-okay-button').attr('onclick', 'save()');
        }

        function save(){
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
