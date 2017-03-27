@extends('layouts.super-admin')

@section('page-title')
    Home | eQMS
@endsection

@section('nav-home') active @endsection

@section('page-content')
<div class="page-content-wrap" style="margin-top: 50px;">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">

                    <br><br>
                    <h1 style="text-align: center;">Welcome to eQMS!</h1><br><br>
                    <div style="text-align: center; padding-left:50px; padding-right:50px; padding-bottom:50px;">
                        <h4>
                        This site is currently being developed in an attempt to convert NSCPI's Quality Manuals into electronic format. We are hoping that through this system, we will be able to maintain and enhance the center's documented Quality Policies and Procedures more dynamically.<br><br><br>We are really working hard to create a highly usable system but since this is a work in progress, we wish to apologize in advance for momentary errors that you might encounter. Nevertheless, we will highly appreciate if you can notify us by dropping an email to <span style="font-weight: bold;">info@newsim.ph</span> should you encounter any.
                    </h4>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="x-content" >
        <div class="x-content-inner" style="margin-top:-20px;">
            <div class="row">
                <div class="col-md-8">

                    <div class="x-block">
                        <div class="x-block-head">
                            <h3>REVISION REQUESTS</h3>
                            <div class="pull-right">
                                <div class="btn-group">
                                    <a href="#" data-toggle="dropdown" class="btn btn-danger dropdown-toggle">NEW   <span class="caret" style="margin-left: 20px;"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#">Draft</a></li>
                                        <li><a href="{{ route('revision-requests.create') }}">Revision Request</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="x-block-content">
                            <table class="table x-table">
                                <tr>

                                    <th width="30%">USER</th>
                                    <th width="40%">REFERENCE DOCUMENT</th>
                                    <th width="30%">STATUS</th>
                                    <th></th>
                                </tr>
                                @foreach($revisionRequests as $revisionRequest)
                                    <tr>
                                        <td>
                                            <a href="#" class="x-user">
                                                <img src="{{ url('img/no-profile-image.png') }}">
                                                <span>{{ $revisionRequest->author_name }}</span>
                                            </a>
                                            <span>{{ $revisionRequest->created_at->toDayDateTimeString() }}</span>
                                        </td>
                                        <td><a href="#">{{ $revisionRequest->reference_document->title }}</a></td>
                                        <td><span class="label label-default" style="color: white;">pending</span></td>
                                        <td><button class="btn btn-info btn-rounded btn-condensed btn-sm" onclick="location.href = '{{ route('revision-requests.show', $revisionRequest->id) }}';">View</button></td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>

                    <ul class="pagination pagination-sm push-up-20">
                        <li class="disabled"><a href="#">Previous</a></li>
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li><a href="#">Next</a></li>
                    </ul>

                </div>
                <div class="col-md-4">

                    <div class="x-block">
                        <div class="x-block-head">
                            <h3>REVISION LOGS</h3>
                            <div class="pull-right">
                                <button class="btn btn-default">ACTIONS <span class="fa fa-angle-down" style="margin-left: 20px;"></span></button>
                            </div>
                        </div>
                        <div class="x-block-content x-todo">
                            <div class="x-todo-header">
                                <label class="check"><input type="checkbox" class="icheckbox"></label>
                                <h3>7 NEW TASKS FOR TODAY</h3>
                                <button class="btn btn-default pull-right">TODAY: 14 SEP. 2015 <span class="fa fa-angle-down"></span></button>
                            </div>
                            <div class="x-todo-content">
                                @foreach($revisionLogs as $revisionLog)
                                    <div class="item">
                                        <div class="head">
                                            <div class="pull-left"><span class="status status-medium"></span> Status: Approved</div>
                                            <div class="pull-left">{{ $revisionLog->section }}</div>
                                            <div class="pull-right"><span class="fa fa-clock-o"></span> {{ $revisionLog->created_at->toDayDateTimeString() }}</div>
                                        </div>
                                        <div class="title">
                                            <h4><span class="fa fa-file-text-o"></span>  {{ $revisionLog->manual_reference }}</h4>
                                        </div>
                                        <div class="content">
                                            {{ $revisionLog->description }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="x-todo-footer">
                                <div class="pull-right">
                                    <a href="#"><span class="fa fa-plus"></span> Add new task</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script type='text/javascript' src='/js/plugins/icheck/icheck.min.js'></script>
@endsection
