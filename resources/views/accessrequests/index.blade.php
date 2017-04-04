@extends('layouts.super-admin')

@section('page-title')Access Requests |eQMS @endsection

@section('nav-actions') active @endsection

@section('page-content')
<div class="page-content-wrap">

    <div class="x-content" >
        <div class="x-content-inner" style="margin-top:-20px;">

            <div class="row">
                <div class="col-md-12">

                    <div class="x-block">
                        <div class="x-block-head">
                            <h3>Access Requests</h3>

                        </div>
                        <div class="x-block-content">
                            <table class="table x-table">
                                <tr>
                                    <th>USER</th>
                                    <th>REASON FOR ACCESS</th>
                                    <th>DATE</th>
                                    <th>STATUS</th>
                                    <th>ACTION</th>
                                </tr>
                                @foreach($accessRequests as $accessRequest)
                                <tr>
                                    <td width="20%">
                                        <a href="#" class="x-user"><img src="{{ url('img/no-profile-image.png') }}"><span>{{ $accessRequest->user_name }}</span></a>
                                    </td>
                                    <td>
                                        {{ $accessRequest->purpose }}
                                    </td>
                                    <td width="15%">
                                        {{ $accessRequest->created_at->toDayDateTimeString() }}
                                    </td>
                                    <td width="10%">
                                        <span class="label label-info" style="color: white;">{{ $accessRequest->status }}</span>
                                    </td>
                                    <td width="10%">
                                        <a href="#" class="btn btn-success btn-rounded btn-condensed btn-sm" onclick="showModal({{ $accessRequest->id }}); return false;" ><span class="fa fa-check" style="color:rgb(149,183,93)"></span></button>
                                        <a href="#" class="btn btn-danger btn-rounded btn-condensed btn-sm" onclick="deny_request({{ $accessRequest->id }})" style="margin-left: 4px;"><span class="fa fa-times" style="color:rgb(182,70,69)"></span></button>
                                    </td>
                                    <form method="POST" action="{{ route('access-requests.destroy', $accessRequest->id) }}" accept-charset="UTF-8" id="form-delete{{ $accessRequest->id }}">
                                        {{ csrf_field() }}
                                        {{ method_field('delete') }}
                                    </form>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    {{ $accessRequests->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modals')
<div class="modal fade" id="modal_change_password" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="smallModalHead">Add Revision Request Number</h4>
            </div>
            <div class="modal-body">
                <p>Enter the revision request number to the document. You may only print Revision Request which revision request number has been supplied.</p>
            </div>
            <form id="form_add_revision_request_number" class="form-horizontal" action="index.html" method="post">
                {{ csrf_field() }}
                {{ method_field('put') }}
                <div class="modal-body form-horizontal form-group-separated">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Duration</label>
                        <div class="col-md-9">
                            <select class="form-control select" name="duration">
                                <option value="12">12 Hours</option>
                                <option value="24">24 Hours</option>
                                <option value="48">48 Hours</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('message-box')
    <!-- MESSAGE BOX-->
    <div class="message-box animated fadeIn" data-sound="alert" id="mb-deny-request">
        <div class="mb-container">
            <div class="mb-middle">
                <div class="mb-title"><span class="fa fa-times"></span> Deny <strong>Access</strong> ?</div>
                <div class="mb-content">
                    <p>Are you sure you want to remove this Section?</p>
                    <p>Documents belong to this section will not be available</p>
                    <p>Press Yes if you sure.</p>
                </div>
                <div class="mb-footer">
                    <div class="pull-right">
                        <button class="btn btn-success btn-lg mb-control-yes">Yes</button>
                        <button class="btn btn-default btn-lg mb-control-close">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MESSAGE BOX-->
@endsection

@section('scripts')
<script type="text/javascript" src="{{ url('js/plugins/bootstrap/bootstrap-select.js') }}"></script>
<script type="text/javascript">
    function showModal(id) {
        $("#form_add_revision_request_number").attr('action', "/access-requests/" + id);
        $("#modal_change_password").modal();
    }

    function deny_request(row){
        var box = $('#mb-deny-request');
        box.addClass("open");
        box.find(".mb-control-yes").on("click",
            function(){
                box.removeClass("open");
                document.getElementById('form-delete' + row).submit();
            }
        );
    }
</script>
@endsection
