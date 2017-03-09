@extends('./layouts/super-admin')

@section('page-title')Revision Request |eQMS @endsection

@section('nav-actions') active @endsection

@section('page-content')
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="page-title">
        <h2><span class="fa fa-pencil"></span> Revision Request</h2>
    </div>

    <div class="row">
        <div class="col-md-9">

            <form class="form-horizontal">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3>Section A: Formal Request</h3>
                        <p>This is to formalize a request for a revision to the document as follows:</p>
                    </div>
                    <div class="panel-body form-group-separated">
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">Revision Request No.</label>
                            <div class="col-md-9 col-xs-7">
                                <label class="control-label">NCPI-QMR-2001-24</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">Date Submitted</label>
                            <div class="col-md-9 col-xs-7">
                                <label class="control-label">{{ $revisionRequest->created_at->toFormattedDateString() }}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">Reference Document</label>
                            <div class="col-md-9 col-xs-7">
                                <a href="#" target="_blank"><label class="control-label">{{ $revisionRequest->reference_document->title }}</label></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Section / Page / Process</label>
                            <div class="col-md-9 col-xs-12">
                                <input type="text" class="tagsinput" value="{{ $revisionRequest->reference_document_tags }}"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">Attachments</label>
                            <div class="col-md-9 col-xs-7">
                                <input type="file" multiple class="file" data-preview-file-type="any" name="attachments"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">Reason for Revision</label>
                            <div class="col-md-9 col-xs-7">
                                <textarea class="form-control" rows="5" name="revision_reason">{{ $revisionRequest->revision_reason }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 col-xs-12">
                                <label class="control-label" style="margin-bottom: 10px;">Proposed Revision</label>
                                <div class="panel-body" style="background-color: rgb(249,249,249); padding: 20px;">
                                    {!! $revisionRequest->proposed_revision !!}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </form>

            <form enctype="multipart/form-data" class="form-horizontal" action="{{ route('revision-requests.update', $revisionRequest->id) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('put') }}
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3>Section B: QMR's Recommendation</h3>
                        <p>For Approval/Disapproval</p>
                    </div>
                    <div class="panel-body form-group-separated">
                        <div class="form-group">
                            <label class="col-md-3 col-xs-7 control-label">Recommendation Status</label>
                            <div class="col-md-9 col-xs-5">
                                <select class="form-control select" name="recommendation_status">
                                    <option value="for-approval">For Approval</option>
                                    <option value="for-disapproval">For Disapproval</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">Reason for Recommendation / Disapproval</label>
                            <div class="col-md-9 col-xs-7">
                                <textarea class="form-control" rows="5" name="recommendation_reason"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 col-xs-5">
                                <button class="btn btn-primary btn-rounded pull-right">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <form class="form-horizontal">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3>Section C: Approval/Disapproval</h3>
                        <p>For Approval/Disapproval</p>
                    </div>
                    <div class="panel-body form-group-separated">
                        <div class="form-group">
                            <label class="col-md-3 col-xs-7 control-label">CEO Approval Status</label>
                            <div class="col-md-9 col-xs-5">
                                <select class="form-control select" name="recommendation_status">
                                    <option value="for-approval">Approved</option>
                                    <option value="for-disapproval">Denied</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">Attachment</label>
                            <div class="col-md-9 col-xs-7">
                                <input type="file" multiple class="file" data-preview-file-type="any" name="attachments"/>
                                <span class="help-block">Upload the signed revision request by the CEO.</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">Remarks</label>
                            <div class="col-md-9 col-xs-7">
                                <textarea class="form-control" rows="5" name="recommendation_reason"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <form class="form-horizontal">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3>Section D: Action Taken</h3>
                    </div>
                    <div class="panel-body form-group-separated">
                        <div class="form-group">
                            <label class="col-md-3 col-xs-7 control-label">Action Taken</label>
                            <div class="col-md-9 col-xs-5">
                                <select class="form-control select" name="recommendation_status">
                                    <option value="for-approval">Document Revised</option>
                                    <option value="for-disapproval">Updated</option>
                                    <option value="for-disapproval">Distributed to Holders</option>
                                    <option value="for-disapproval">Others</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">If others, please specify</label>
                            <div class="col-md-9 col-xs-7">
                                <textarea class="form-control" rows="5" name="recommendation_reason"></textarea>
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
<!-- END PAGE CONTENT WRAPPER -->
@endsection

@section('scripts')
<script type="text/javascript" src="{{ url('js/plugins/bootstrap/bootstrap-select.js') }}"></script>
<script type="text/javascript" src="{{ url('js/plugins/fileinput/fileinput.min.js') }}"></script>
<script type="text/javascript" src="{{ url('js/plugins/tagsinput/jquery.tagsinput.min.js') }}"></script>
@endsection
