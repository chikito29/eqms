@extends('layouts.main')

@section('page-title')
    Revision logs
@endsection

@section('page-content')
    <div class="page-content-wrap" style="margin-top: -25px;">
        @if(session('attention'))
            @include('layouts.attention')
        @endif
        <div class="x-content" >
            <div class="x-content-inner" style="margin-top:-20px; height: 90vh;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="x-block">
                            <div class="x-block-head">
                                <h3>Revision Logs</h3>
                                <button class="btn btn-success pull-right @if(App\HelperClasses\User::isDocumentController(request('user.id'))) @else hidden @endif" onclick="add()"><span class="fa fa-user"></span>ADD</button>
                            </div>
                            <table class="table table-striped" id="table-application">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Manual Reference</th>
                                    <th>Brief Description of revision</th>
                                    <th>Revision no.</th>
                                    <th>Approved By</th>
                                    <th class="@if(App\HelperClasses\User::isDocumentController(request('user.id'))) @else hidden @endif" with="120">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($logs as $log)
                                        <tr>
                                            <td>{{ $log->date }}</td>
                                            <td>{{ $log->manual_reference }}</td>
                                            <td>{{ $log->description }}</td>
                                            <td>{{ $log->revision_number }}</td>
                                            <td>{{ $log->approved_by }}</td>
                                            <td class="@if(App\HelperClasses\User::isDocumentController(request('user.id'))) @else hidden @endif">
                                                <form class="form">
                                                    <button class="btn btn-info" type="button" onclick="confirmation('{{ $log->id }}', 'update', '{{ $log }}')"><span class="fa fa-edit"></span> Edit</button>
                                                    <button class="btn btn-danger" type="button" onclick="confirmation('{{ $log->id }}', 'delete')"><span class="fa fa-trash"></span> Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <div class="modal fade" id="confirmation-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Confirm your action</h4>
                </div>
                <div class="modal-body">
                    Confirm <strong>deletion</strong> of user.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="$('.form').submit()">Continue</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" id="add-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Add Revision log</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="POST" action="{{ route('revision-logs.store') }}" id="log-form">
                        {{ csrf_field() }}
                        <div class="panel-body form-group-separated">

                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Date</label>
                                <div class="col-md-9 col-xs-12">
                                    <input type="text" class="datepicker form-control" name="date">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Manual Reference</label>
                                <div class="col-md-9 col-xs-12">
                                    <select class="form-control select" data-live-search="true" name="document-id">
                                        <option value="null" style="display: none;">Click to choose manual reference</option>
                                        @foreach($documentTitle as $title)
                                            <option value="{{ $title->id }}">{{ $title->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Description</label>
                                <div class="col-md-9 col-xs-12">
                                    <textarea name="description" rows="4" class="form-control"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Revision Number</label>
                                <div class="col-md-9 col-xs-12">
                                    <label class="control-label"></label>
                                    <input type="text" name="revision-number" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Approved by</label>
                                <div class="col-md-9 col-xs-12">
                                    <select name="approved-by" class="form-control select">
                                        <option value="null" style="display: none;">Who approved the revision?</option>
                                        <option value="CEO">CEO</option>
                                        <option value="COO">COO</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div><!-- /.modal-body -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
@stop

@section('scripts')
    {{--adding logic--}}
    <script type="text/javascript" src="{{ url('js/plugins/bootstrap/bootstrap-datepicker.js')}}"></script>
    <script type="text/javascript" src="{{ url('js/plugins/bootstrap/bootstrap-timepicker.min.js')}}"></script>
    <script type="text/javascript" src="{{ url('js/plugins/bootstrap/bootstrap-colorpicker.js')}}"></script>
    <script type="text/javascript" src="{{ url('js/plugins/bootstrap/bootstrap-file-input.js')}}"></script>
    <script type="text/javascript" src="{{ url('js/plugins/bootstrap/bootstrap-select.js')}}"></script>
    <script type="text/javascript" src="{{ url('js/plugins/tagsinput/jquery.tagsinput.min.js')}}"></script>
    <script>
        $(function(){
            defaultModalBody = $('#modal-body').html();
        });

        function confirmation(id, action, log){
            if(action == 'update'){
                alert(log);
                $('#modal-title').html('Edit Revision Log');
                $('#log-form').attr('action', '/revision-logs/' + id);
                $('#log-form').append('{{ method_field('patch') }}');

                //populate form elements
                $('input[name="date"]').val(log['date']);
                $('select[name="document-id"]').val(log['id']);
                $('select[name="document-id"]').selectpicker('refresh');
                $('textarea[name="description"]').html(log['description']);
                $('input[name="revision-number"]').val(log['revision_number']);
                $('input[name="approved-by"]').val(log['approved_by']);

                $('#add-modal').modal('toggle');
            } else {
                $('.form').attr({
                    action: '/revision-logs/' + id,
                    method: 'post'
                });
                $('.form').append('{{ csrf_field() }} {{ method_field('delete') }}');
                $('#confirmation-modal').modal('toggle');
            }
        }

        function add() {
            $('#modal-body').html(defaultModalBody);
            $('#add-modal').modal('toggle');
        }
    </script>
@stop
