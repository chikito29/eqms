@extends('layouts.main')

@section('page-title')
    Settings
@endsection

@section('page-content')
    <div class="page-content-wrap" style="margin-top: -25px;">
        @if(session('attention'))
            @include('layouts.attention')
        @endif
        <div class="x-content" >
            <div class="x-content-inner" style="margin-top:-20px;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="x-block">
                            <div class="x-block-head">
                                <h3>Administrators List</h3>
                                <button class="btn btn-success pull-right" onclick="addUser()"><span class="fa fa-user"></span>ADD</button>
                            </div>
                            <table class="table table-striped" id="table-application">
                                <thead>
                                <tr>
                                    <th>Added By</th>
                                    <th>Full Name</th>
                                    <th>Role</th>
                                    <th>Branch</th>
                                    <th>Department</th>
                                    <th with="120">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($eqmsUsers as $user)
                                        <tr>
                                            <td>{{ $user->added_by }}</td>
                                            <td>{{ $user->fullname }}</td>
                                            <td>{{ $user->role }}</td>
                                            <td>{{ $user->branch }}</td>
                                            <td>{{ $user->department }}</td>
                                            <td>
                                                <form id="form{{ $user->id }}" class="indexForm">
                                                    <button type="button" onclick="edit('{{ $user->id }}', '{{ $user->user_id }}', '{{ $user->role }}')" class="btn btn-info"><span class="fa fa-edit"></span>Edit</button>
                                                    <button type="button" onclick="confirmDelete('{{ $user->id }}')" class="btn btn-danger"><span class="fa fa-trash"></span>Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
                    <button type="button" class="btn btn-primary" name="modal-continue-btn">Continue</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" id="add-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Add Administrator</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="POST" action="{{ route('settings.store') }}" id="user-form">
                        {{ csrf_field() }}
                        {{--user's fullname--}}
                        <input type="text" class="hidden" name="fullname">
                        <input type="text" class="hidden" name="department">
                        <input type="text" class="hidden" name="email">
                        <div class="panel-body">
                            <p>Add new eQMS user.<br><strong>Note: eQMS can only have one admin at a time.</strong></p>
                        </div>
                        <div class="panel-body form-group-separated">

                                <div class="form-group">
                                    <label class="col-md-3 col-xs-12 control-label">Add As</label>
                                    <div class="col-md-9 col-xs-12">
                                        <select class="form-control select" name="role">
                                            @if($eqmsUsers->where('role', 'Admin')->count() == 0)
                                                <option value="Admin">Admin</option>
                                            @endif
                                            <option value="Document Controller">Document Controller</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 col-xs-12 control-label">Employee Name</label>
                                    <div class="col-md-9 col-xs-12">
                                        <select class="form-control select" data-live-search="true" name="employee_id">
                                            <option style="display: none;" value="default">Select Employee</option>
                                            @foreach($employees as $employee)
                                                @foreach($eqmsUsers->pluck('user_id') as $userId)
                                                    @if($employee->id == $userId)
                                                        <option style="display: none;" value="{{ $employee->id }}" email="{{ $employee->email }}" branch="{{ $employee->branch }}" department="{{ $employee->department }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                                                        @break
                                                    @else
                                                        <option value="{{ $employee->id }}" email="{{ $employee->email }}" branch="{{ $employee->branch }}" department="{{ $employee->department }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                                                        @break
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 col-xs-12 control-label">Branch</label>
                                    <div class="col-md-6 col-xs-12">
                                        <label class="control-label" id="branch"></label>
                                        <input type="text" class="form-control hidden" name="branch"/>
                                    </div>
                                </div>
                            </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
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
        $('select').on('change', function() {
            var option = $(this).find('option:selected');
            $('input:text[name="branch"]').val(option.attr('branch'));
            $('#branch').html(option.attr('branch'));
            $('input:text[name="fullname"]').val(option.html());
            $('input:text[name="department"]').val(option.attr('department'));
            $('input:text[name="email"]').val(option.attr('email'));
        })

        var formAdd = $('#user-form').html();

        function add() {
            var userForm = $('#user-form');
            userForm.html(formAdd);
            $('#add-modal').modal('toggle');
        }
    </script>
    {{--end adding logic--}}

    {{--edit and delete--}}
    <script>
        var userId;
        var formBody;
        var form;
        var originalForm = $('.indexForm').html();

        function confirmDelete(id){
            userId = id;
            form = $('#form' + id);
            formBody = $('#form' + id).html();

            form.attr({
                action: '/settings/' + id,
                method: 'post'
            });
            form.prepend('{{ method_field("delete") }}', '{{ csrf_field() }}');
            $('.modal-body').html('Confirm <strong>deletion</strong> of user.');
            $('button[name="modal-continue-btn"]').attr('onclick', 'deleteUser()');

            $('#confirmation-modal').modal('toggle');
        }

        function deleteUser(){
            $('#form' + userId).submit();
        }

        function addUser(){
            $('select[name="employee_id"]').val('default');
            $('select[name="employee_id"]').selectpicker('refresh');
            $('#branch').html("");
            $('.modal-title').html('Add Administrator');
            $('#add-modal').modal('toggle');
        }

        function edit(id, userId, role){
            $('#user-form').attr({
                action: '/settings/' + id,
                method: 'post'
            });
            $('#user-form').prepend('{{ csrf_field() }}', '{{ method_field('patch') }}');

            //populate selects
            var selectRole = $('select[name="role"]');
            if(role == 'Admin'){
                selectRole.prepend('<option value="Admin">Admin</option>');
            }
            selectRole.val(role);
            selectRole.selectpicker('refresh');
            var selectEmployee = $('select[name="employee_id"]');
            selectEmployee.val(userId);
            selectEmployee.selectpicker('refresh');
            selectEmployee.trigger('change');

            $('.modal-title').html('Edit Administrator');
            $('#add-modal').modal('toggle');
        }
    </script>
    {{--end edit and delete--}}
@stop