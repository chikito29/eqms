@extends('layouts.main')

@section('page-title') Edit CPAR | eQMS @stop

@section('nav-audit-findings') active @stop

@section('page-content')
    <div class="page-content-wrap">

        <div class="page-title">
            <h2><span class="fa fa-pencil"></span> CORRECTIVE AND PREVENTIVE ACTION REPORT FORM</h2>
        </div>

        <div class="row">
            <div class="col-md-9">

                <form enctype="multipart/form-data" class="form-horizontal" action="/cpars/{{ $cpar->id }}" method="POST" role="form">
                    {{ csrf_field() }} {{ method_field('PUT') }}
                    <div class="panel panel-default">
                        <div class="panel-body form-group-separated">
                            @component('components.show-single-line')
                                @slot('label') Raised By @endslot
                                @foreach($result as $employee)
                                    @if($employee->id == $cpar->raised_by)
                                        {{ $employee->first_name }} {{ $employee->last_name }}
                                    @endif
                                @endforeach
                            @endcomponent
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Department</label>
                                <div class="col-md-9 col-xs-12">
                                    <select name="department" class="form-control select"  id="department-select">
                                        <option>Accounting</option>
                                        <option>Human Resource</option>
                                        <option>Information Technology</option>
                                        <option>Internal Audit</option>
                                        <option>Training</option>
                                        <option>Research and Development</option>
                                        <option>Quality Management Representative</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Branch</label>
                                <div class="col-md-9 col-xs-12">
                                    <select name="branch" class="form-control select"  id="branch-select">
                                        <option>Bacolod</option>
                                        <option>Cebu</option>
                                        <option>Davao</option>
                                        <option>Iloilo</option>
                                        <option>Makati</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Severity Of Findings</label>
                                <div class="col-md-9 col-xs-12">
                                    <select class="form-control select" name="severity" id="severity-select">
                                        <option>Observation</option>
                                        <option>Minor</option>
                                        <option>Major</option>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Procedure/Process/Scope/Other References</label>
                                <div class="col-md-9 col-xs-12">
                                    <select class="form-control select" name="reference" id="reference-select" onchange="showLink()" data-live-search="true">
                                        @foreach($sections as $section)
                                            @foreach($section->documents as $document)
                                                <option value="{{ $document->id }}">{{ $document->title }}</option>
                                            @endforeach
                                        @endforeach
                                    </select> <br><br>
                                    <h6><span id="span-reference"><a href="{{ route('documents.show', $cpar->id) }}">{{ route('documents.show', $cpar->id) }}</a></span></h6>
                                    <input type="text" class="tagsinput" name="tags" value="{{ $cpar->tags }}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Source Of Non-Comformity</label>
                                <div class="col-md-9 col-xs-12">
                                    <select class="form-control select" name="source" id="source-select">
                                        <option>External</option>
                                        <option>Internal</option>
                                        <option>Operational Performance</option>
                                        <option>Customer Feedback</option>
                                        <option>Customer Complain</option>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-5 control-label">Others: (Please specify)</label>
                                <div class="col-md-9 col-xs-7">
                                    <textarea class="form-control" rows="3" name="other-source">{{ $cpar->other_source }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-5 control-label">Details</label>
                                <div class="col-md-9 col-xs-7">
                                    <textarea class="form-control" rows="5" name="details">{{ $cpar->details }}</textarea>
                                </div>
                            </div>
                            @component('components.show-single-line')
                                @slot('label') Name @endslot
                                @foreach($result as $employee)
                                    @if($employee->id == $cpar->raised_by)
                                        {{ $employee->first_name }} {{ $employee->last_name }}
                                    @endif
                                @endforeach
                                @slot('help') Person Reporting To Non-Conformity @endslot
                            @endcomponent
                            <div class="form-group @if($errors->first('person-responsible')) has-error @endif">
                                <label class="col-md-3 col-xs-12 control-label">Name</label>
                                <div class="col-md-9 col-xs-12">
                                    <select class="form-control select" name="person-responsible" id="person-responsible" data-live-search="true"></select>
                                    @if($errors->first('person-responsible')) @component('layouts.error') {{ $errors->first('person-responsible') }} @endcomponent
                                    @else <span class="help-block">Person Responsible For Taking The CPAR</span> @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Proposed Corrective Action Complete Date</label>
                                <div class="col-md-9 col-xs-12">
                                    <input type="text" class="form-control datepicker" name="proposed-date" value="{{ $cpar->proposed_date }}"/>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Department Head</label>
                                <div class="col-md-9 col-xs-12">
                                    <select class="form-control select" name="department-head" id="department-head" data-live-search="true"></select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12 col-xs-5">
                                    <button class="btn btn-primary btn-rounded pull-right">Save Changes</button>
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

            //populate select elements
            $('#department-select').val('{{ $cpar->department }}');
            $('#department-select').selectpicker('refresh');
            $('#branch-select').val('{{ $cpar->branch }}');
            $('#branch-select').selectpicker('refresh');
            $('#severity-select').val('{{ strip_tags(str_replace('&nbsp;', '', $cpar->severity)) }}');
            $('#severity-select').selectpicker('refresh');
            $('#reference-select').val("{{ $cpar->document_id }}");
            $('#reference-select').selectpicker('refresh');
            $('#source-select').val('{{ $cpar->source }}');
            $('#source-select').selectpicker('refresh');

            employeeOptions = "";
            @foreach($result as $employee)
                @if(request('user.id') == $employee->id) @continue
                    @else employeeOptions+= '<option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>';
                @endif
            @endforeach
            $('#person-responsible').empty().append(employeeOptions);

            chiefOptions = "";
            @foreach($result as $employee)
                @if($employee->department_head == 1)
                    chiefOptions+= '<option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>';
                @endif
            @endforeach
            $('#department-head').empty().append(chiefOptions);
        });

        $('#summernote').summernote({
            height: 300,
            toolbar: [
                ['misc', ['fullscreen']],
            ]
        });
    </script>

    <script>
        function showLink() {
            $('#span-reference').html("<a href="
                + "\"/documents/"
                + $('#reference').children(':selected').attr('id')
                + "\""
                + " target=\"_blank\">"
                + "Open "
                + $('#reference').children(':selected').html()
                + " in new tab"
                + "</a>");
        }
    </script>
@stop