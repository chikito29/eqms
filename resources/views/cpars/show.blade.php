@extends('layouts.main')

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

                <form class="form-horizontal" role="form" id="form-cpar" action="/action-summary/{{ $cpar->id }}" method="GET">
                    {{ csrf_field() }}
                    <div class="panel panel-default">
                        <div class="panel-body form-group-separated">
                            @if($cpar->cpar_number)
                                @component('components.show-single-line')
                                    @slot('label') CPAR Number @endslot
                                    {{ $cpar->cpar_number }}
                                @endcomponent
                            @endif
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
                                </div>
                            </div>
                            @component('components.show-single-line')
                                @slot('label') Source Of Non-Comformity @endslot
                                    {{ $cpar->source }}
                            @endcomponent
                            @component('components.show-multi-line')
                                @slot('label') Others: (Please specify) @endslot
                                {{ $cpar->other_source }}
                            @endcomponent
                            @component('components.show-multi-line')
                                @slot('label') Details @endslot
                                {{ $cpar->details }}
                            @endcomponent
                            @component('components.show-single-line')
                                @slot('label') Name @endslot
                                @foreach($employees as $employee)
                                    @if($employee->id == $cpar->raised_by)
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
                            @if($cpar->correction)
                                @component('components.show-multi-line')
                                    @slot('label') Correction @endslot
                                    {{ $cpar->correction }}
                                    @slot('help') Action To Eliminate The Detected Non-Conformity @endslot
                                @endcomponent
                            @endif
                            @if($cpar->root_cause)
                                @component('components.show-multi-line')
                                    @slot('label') Root Cause Analysis @endslot
                                    {{ $cpar->correction }}
                                    @slot('help') What Failed In The System To Allow This Non-Conformance To Occur? @endslot
                                @endcomponent
                            @endif
                            @if($cpar->cp_action)
                                @component('components.show-multi-line')
                                    @slot('label') Corrective/Preventive Action @endslot
                                    {{ $cpar->cp_action }}
                                    @slot('help') Specific Details Of Corrective Action Taken To Prevent Recurrence/Occurrence @endslot
                                @endcomponent
                            @endif
                            @component('components.show-single-line')
                                @slot('label') Proposed Corrective Action Complete Date @endslot
                                {{ $cpar->proposed_date }}
                            @endcomponent
                            @if($cpar->date_completed)
                                @component('components.show-single-line')
                                    @slot('label') Corrective/Preventive Complete Date @endslot
                                    {{ $cpar->date_completed }}
                                @endcomponent
                            @endif
                            @component('components.show-single-line')
                                @slot('label') Department Head @endslot
                                @foreach($employees as $employee)
                                    @if($employee->id == $cpar->chief)
                                        {{ $employee->first_name }} {{ $employee->last_name }}
                                    @endif
                                @endforeach
                            @endcomponent
                            @if($cpar->date_confirmed)
                                @component('components.show-single-line')
                                    @slot('label') Date Confirmed By Department Head @endslot
                                    {{ $cpar->date_confirmed }}
                                @endcomponent
                            @endif
                            @if($cpar->cparAnswered->status == 1)
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <h4><strong>To Be Filled By The QMR / Auditor</strong></h4>
                                    </div>
                                </div>
                                @if($cpar->cpar_acceptance)
                                    @component('components.show-multi-line')
                                        @slot('label') Acceptance of CPAR @endslot
                                        {{ $cpar->cpar_acceptance }}
                                        @slot('help') Comments If Any @endslot
                                    @endcomponent
                                @endif
                                @component('components.show-single-line')
                                    @slot('label') Date Cpar Accepted @endslot
                                    {{ $cpar->date_accepted }}
                                @endcomponent
                                @if($cpar->verified_by)
                                    @component('components.show-single-line')
                                        @slot('label') Name @endslot
                                        @foreach($employees as $employee)
                                            @if($employee->id == $cpar->verified_by)
                                                {{ $employee->first_name }} {{ $employee->last_name }}
                                            @endif
                                        @endforeach
                                        @slot('help') QMR / AUDITOR / CEO @endslot
                                    @endcomponent
                                @endif
                                @if($cpar->cpar_acceptance)
                                    @component('components.show-single-line')
                                        @slot('label') Verification Date @endslot
                                        {{ $cpar->date_verified }}
                                    @endcomponent
                                @endif
                                @if($cpar->result)
                                    @component('components.show-multi-line')
                                        @slot('label') Result Of Verification @endslot
                                        {{ $cpar->result }}
                                    @endcomponent
                                @endif
                                <div class="form-group">
                                    <label class="col-md-3 col-xs-5 control-label">Attachments</label>
                                    <div class="col-md-9 col-xs-7">
                                        <li class="list-unstyled">
                                            @if($cpar->attachments->count() > 0)
                                                @foreach($cpar->attachments as $attachment)
                                                    <ul>{{  $attachment->file_name }} added by {{ $attachment->uploaded_by }}</ul>
                                                @endforeach
                                            @else
                                                No Attachment Avaible For This CPAR
                                            @endif
                                        </li>
                                    </div>
                                </div>
                                @yield('verify-button')
                            @endif
                            @if(request('user.type') == 'admin')
                                <div class="panel-footer">
                                    <button type="button" class="btn btn-primary btn-rounded pull-right" onclick="printCpar()">Print CPAR</button>
                                </div>
                            @endif
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

@yield('modals')

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