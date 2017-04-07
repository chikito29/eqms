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
                                <h3>Users List</h3>
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
                                                <form method="post" action="/settings/{{ $user->id }}" id="formDelete{{ $user->id }}">
                                                    {{ csrf_field() }} {{ method_field('delete') }}
                                                    <button type="button" onclick="confirm('{{ $user->id }}', 'delete')" class="btn btn-danger"><span class="fa fa-trash"></span>Delete</button>
                                                </form>
                                                <form method="get" action="/settings/{{ $user->id }}" id="formEdit{{ $user->id }}">
                                                    {{ csrf_field() }}
                                                    <button type="button" onclick="confirm('{{ $user->id }}', 'edit')" class="btn btn-danger"><span class="fa fa-trash"></span>Delete</button>
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
@stop

@section('scripts')
    <script>
        var userId;

        function confirm(id, action){
            userId = id;
            if(action == 'edit') {
                $('button:text[name="modal-continue-btn"]').attr('onclick', 'editUser()');
            } else {
                $('button:text[name="modal-continue-btn"]').attr('onclick', 'deleteUser()');
            }
            $('#confirmation-modal').modal('toggle');
        }

        function deleteUser(){
            $('#formDelete' + userId).submit();
        }

        function editUser(){
            $('#formEdit' + userId).submit();
        }
    </script>
@stop