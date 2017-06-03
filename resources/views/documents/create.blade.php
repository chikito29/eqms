@extends('layouts.main')

@section('page-title')New Document | eQMS @endsection

@section('nav-actions') active @endsection

@section('page-content')
    <div class="page-content-wrap" style="margin-top:-20px; height: 90vh;">

        <div class="page-title">
            <h2><span class="fa fa-file-text-o"></span> New Document</h2>
        </div>

        <div class="row">
            <div class="col-md-9">
                <form class="form-horizontal" action="{{ URL::route('documents.store') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="panel panel-default">
                        <div class="panel-body form-group-separated">
                            <div class="form-group">
                                <label class="col-md-3 col-xs-5 control-label">Document Title</label>
                                <div class="col-md-9 col-xs-7">
                                    <input type="text" class="form-control" name="title"/>
                                    @if ($errors->has('title'))
                                    <span class="help-block successful"><strong class="text-danger">{{ $errors->first('title') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-5 control-label">Section</label>
                                <div class="col-md-9 col-xs-7">
                                    <select id="select" name="section-id" class="form-control select" data-live-search="true" >
                                        @foreach($sections as $section)
                                        <option value="{{ $section->id }}">{{ $section->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if ($errors->has('section-id'))
                                <span class="help-block successful">
                                    <strong class="text-danger">{{ $errors->first('section-id') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="col-md-12 col-xs-12">
                                    <textarea id="summernote" name="body"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12 col-xs-5">
                                    <button class="btn btn-primary btn-rounded pull-right">Post</button>
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
@endsection

@section('scripts')
<script type="text/javascript" src="{{ url('js/plugins/summernote/summernote.js') }}"></script>
<script type="text/javascript" src="{{ url('js/plugins/bootstrap/bootstrap-select.js') }}"></script>
<script type="text/javascript">
    $('#summernote').summernote({
        height: 500
    });
</script>
@endsection
