@extends('layouts.main')

@section('page-title')
  eQMS | Create User
@stop

@section('page-content')
<div class="row">
        <div class="col-md-12">

            <form class="form-horizontal" method="POST" action="{{ route('settings.store') }}">
                {{ csrf_field() }}
                {{--user's fullname--}}
                <input type="text" class="hidden" name="fullname">
                <input type="text" class="hidden" name="department">
                <input type="text" class="hidden" name="email">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p>Add new eQMS user.<br><strong>Note: eQMS can only have one admin at a time.</strong></p>
                    </div>
                    <div class="panel-body form-group-separated">

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Add As</label>
                            <div class="col-md-6 col-xs-12">
                                    <select class="form-control select" name="role">
                                        @if(\App\EqmsUser::where('role', 'Admin')->get()->count() == 0 )
                                            <option>Admin</option>
                                        @endif
                                        <option>Document Controller</option>
                                    </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Employee Name</label>
                            <div class="col-md-6 col-xs-12">
                                <select class="form-control select" data-live-search="true" name="employee_id" onchange="setBranch()">
                                    <option style="display: none;">Select Employee</option>
                                    @foreach($result as $employee)
                                        @if(request('user.id') == $employee->id)
                                            @continue
                                        @else
                                            <option value="{{ $employee->id }}" email="{{ $employee->email }}" branch="{{ $employee->branch }}" department="{{ $employee->department }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                                        @endif
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
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-primary pull-right">Save</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@stop

@section('scripts')
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
</script>

@stop