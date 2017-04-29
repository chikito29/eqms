@extends('layouts.main')

@section('page-title')
    eQms | Logs
@endsection

@section('nav-settings') active @endsection

@section('page-content')
    <div class="page-content-wrap" style="margin-top: 50px;">
        <div class="page-title">
            <h2><span class="fa fa-eye"></span> eQMS Logs</h2>
        </div>

        <div class="row">
            <div class="col-md-9">
                <!-- START BASIC TABLE SAMPLE -->
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Page URL</th>
                                    <th>IP Address</th>
                                    <th>Date and Time</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($logs->count() != 0)
                                @foreach($logs as $log)
                                <tr onclick="getUser({{ $log->user_id }})" style="cursor: pointer;">
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
            <div class="col-md-3" style="position: fixed; top: 12em; right: 1em;">

                <div class="panel panel-default form-horizontal">
                    <div class="panel-body">
                        <h3><span class="fa fa-info-circle"></span> Quick Info</h3>
                        <p>Some quick info about this user</p>
                    </div>
                    <div class="panel-body form-group-separated">
                        <div class="form-group">
                            <label class="col-md-4 col-xs-5 control-label">Full name</label>
                            <div class="col-md-8 col-xs-7 line-height-30" name="full-name"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-5 control-label">Username</label>
                            <div class="col-md-8 col-xs-7 line-height-30" name="username"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-5 control-label">Department</label>
                            <div class="col-md-8 col-xs-7" name="department"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-5 control-label">Branch</label>
                            <div class="col-md-8 col-xs-7 line-height-30" name="branch"></div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>
@stop

@section('scripts')
    <script>
    function getUser(id) {
        $.get( '/user-details/' + id, function( data ) {
            var user = JSON.parse(data);
            $('div[name="full-name"]').html(user.first_name + ' ' + user.last_name);
            $('div[name="username"]').html(user.username);
            $('div[name="department"]').html(user.department);
            $('div[name="branch"]').html(user.branch);
        });
    }
    </script>
@stop