@extends('layouts.main')

@section('page-title') eQms | Logs @endsection

@section('nav-settings') active @endsection

@section('page-content')
    <div class="page-content-wrap" style="margin-top: -25px;">
        <div class="x-content" >
            <div class="x-content-inner" style="margin-top:-20px; height: 90vh;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="x-block-head">
                            <h3>System Logs</h3>
                        </div>
                        <!-- START BASIC TABLE SAMPLE -->
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color: #95b75d;">
                                <h3 class="panel-title"><strong>Filter/Search Logs</strong></h3>
                                <ul class="panel-controls">
                                    <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                                </ul>
                            </div>
                            <div class="panel-body">
                                <form class="form-horizontal" action="{{ route('logs.index') }}" method="get">
                                    <div id="detailed-search">
                                        <div class="form-group col-md-10">
                                            <label>To view all logs, just empty selections and click submit.</label>
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label>Full Name</label>
                                            <select name="user_id" class="form-control select">
                                                <option value="">Empty selection</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->first_name . ' ' . $user->last_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <label>Date Range (created)</label>
                                            <div class="input-group">
                                                <input type="text" name="created_at" class="form-control datepicker" value="">
                                                <span class="input-group-addon add-on"> - </span>
                                                <input type="text" name="updated_at" class="form-control datepicker" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-10"><button class="btn btn-success pull-right">Submit</button></div>
                                </form>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Full name</th>
                                            <th>Position</th>
                                            <th>Branch</th>
                                            <th>Department</th>
                                            <th>Action</th>
                                            <th>Page URL</th>
                                            <th>IP Address</th>
                                            <th>Date and Time</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($logs->count() != 0)
                                            @foreach($logs as $log)
                                            <tr>
                                                @foreach($users as $user)
                                                    @if($user->id == $log->user_id)
                                                        <td>{{ $user->first_name . ' ' . $user->last_name }}</td>
                                                        <td>{{ $user->position }}</td>
                                                        <td>{{ $user->branch }}</td>
                                                        <td>{{ $user->department }}</td>
                                                        @break
                                                    @endif
                                                @endforeach
                                                <td>{{ $log->action }}</td>
                                                <td>{{ $log->page_url }}</td>
                                                <td>{{ $log->ip_address }}</td>
                                                <td>{{ $log->created_at->toDayDateTimeString() }}</td>
                                            </tr>
                                            @endforeach
                                        @else
                                            <tr><td colspan="4" align="center">No logs available</td></tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{ $logs->links() }}
                        </div>
                        <!-- END BASIC TABLE SAMPLE -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script src="{{ url('js/plugins/bootstrap/bootstrap-select.js') }}"></script>
    <script src="{{ url('js/plugins/bootstrap/bootstrap-datepicker.js') }}"></script>
@stop