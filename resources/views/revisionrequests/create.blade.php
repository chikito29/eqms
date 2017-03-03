@extends('./layouts/super-admin')

@section('nav-actions') active @endsection

@section('page-content')
    <div class="page-content-wrap">

        <div class="row">
            <div class="col-md-9">

                <form enctype="multipart/form-data" class="form-horizontal" action="{{ route('revision-requests.store') }}">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h3><span class="fa fa-pencil"></span> New Revision Request</h3>
                            <p>This information lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer faucibus, est quis molestie tincidunt, elit arcu faucibus erat.</p>
                        </div>
                        <div class="panel-body form-group-separated">
                            <div class="form-group">
                                <label class="col-md-2 col-xs-5 control-label">Target Document</label>
                                <div class="col-md-10 col-xs-7">
                                    <select class="form-control select" data-live-search="true" name="target_document">
                                        @foreach($documentTitles as $documentTitle)
                                            <option value="{{ $documentTitle->id }}">{{ $documentTitle->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 col-xs-5 control-label">Title</label>
                                <div class="col-md-10 col-xs-7">
                                    <input type="text" class="form-control" name="title"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 col-xs-5 control-label">Body</label>
                                <div class="col-md-10 col-xs-7">
                                    <textarea class="summernote" name="body"></textarea>
                                </div>
                                @if ($errors->has('body'))
                                    <span class="help-block successful">
                                        <strong class="text-danger">{{ $errors->first('body') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 col-xs-5 control-label">Attachments</label>
                                <div class="col-md-10 col-xs-7">
                                    <input type="file" multiple class="file" data-preview-file-type="any"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 col-xs-5 control-label">Remarks</label>
                                <div class="col-md-10 col-xs-7">
                                    <textarea class="form-control" rows="5" name="remarks"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12 col-xs-5">
                                    <button class="btn btn-primary btn-rounded pull-right">Save</button>
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
@endsection

@section('scripts')
<script type="text/javascript" src="{{ url('js/plugins/summernote/summernote.js') }}"></script>
<script type="text/javascript" src="{{ url('js/plugins/bootstrap/bootstrap-select.js') }}"></script>
<script type="text/javascript" src="{{ url('js/plugins/fileinput/fileinput.min.js') }}"></script>
@endsection
