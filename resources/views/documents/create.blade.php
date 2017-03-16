@extends('./layouts/super-admin')

@section('page-title')New Document |eQMS @endsection

@section('nav-actions') active @endsection

@section('page-content')
    <div class="page-content-wrap">

        <div class="page-title">
            <h2><span class="fa fa-file-text-o"></span> New Document</h2>
        </div>

        <div class="row">
            <div class="col-md-9">
                <form class="form-horizontal" action="{{ URL::route('documents.store') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h3>Section A: Formal Request</h3>
                            <p>This is to formalize a request for a revision to the document as follows:</p>
                        </div>
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
                            <label class="col-md-4 col-xs-5 control-label">Last visit</label>
                            <div class="col-md-8 col-xs-7 line-height-30">12:46 27.11.2015</div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-5 control-label">Registration</label>
                            <div class="col-md-8 col-xs-7 line-height-30">01:15 21.11.2015</div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-5 control-label">Groups</label>
                            <div class="col-md-8 col-xs-7">administrators, managers, team-leaders, developers</div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-5 control-label">Birthday</label>
                            <div class="col-md-8 col-xs-7 line-height-30">14.02.1989</div>
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
