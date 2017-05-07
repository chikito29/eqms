@extends('layouts.main')

@section('page-title') Access Requests | eQMS @endsection

@section('nav-view') active @endsection

@section('page-content')
<div class="page-content-wrap">

    <div class="x-content">
        <div class="x-content-inner" style="margin-top:-45px; height: 90vh;">

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
                                    <th>PURPOSE</th>
                                    <th>DATE</th>
                                    <th>STATUS</th>
                                    <th>ACTION</th>
                                </tr>
                                @if($accessRequests->count() <> 0)
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
                                                    @if($accessRequest->status == 'Pending')
                                                        <span class="label label-info" style="color: white;">{{ $accessRequest->status }}</span>
                                                    @elseif($accessRequest->status == 'Denied')
                                                        <span class="label label-danger" style="color: white;">{{ $accessRequest->status }}</span>
                                                    @elseif($accessRequest->status == 'Revoked')
                                                        <span class="label label-warning" style="color: white;">{{ $accessRequest->status }}</span>
                                                    @else
                                                        <span class="label label-success" style="color: white;">{{ $accessRequest->status }}</span>
                                                    @endif
                                                </td>
                                                <td width="10%">
                                                    @if($accessRequest->status == 'Pending')
                                                        <a href="#" class="btn btn-success btn-rounded btn-condensed btn-sm" onclick="showModal({{ $accessRequest->id }}); return false;" ><span class="fa fa-check" style="color:rgb(149,183,93)"></span></button>
                                                            <a href="#" class="btn btn-danger btn-rounded btn-condensed btn-sm" onclick="deny_request({{ $accessRequest->id }})" style="margin-left: 4px;"><span class="fa fa-times" style="color:rgb(182,70,69)"></span></button>
                                                                @else
                                                                    <a href="#" class="btn btn-danger btn-rounded btn-condensed btn-sm" onclick="revoke_access({{ $accessRequest->id }})" style="margin-left: 4px;">Revoke</button>
                                                    @endif
                                                </td>
                                                <form method="POST" action="{{ route('access-requests.destroy', $accessRequest->id) }}" accept-charset="UTF-8" id="form-delete{{ $accessRequest->id }}">{{ csrf_field() }}{{ method_field('delete') }}</form>
                                                <form method="POST" action="{{ route('access-requests.revoke', $accessRequest->id) }}" accept-charset="UTF-8" id="form-revoke{{ $accessRequest->id }}">{{ csrf_field() }}</form>
                                            </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" align="center"><strong>Hooray! There is no pending access request!</strong></td>
                                    </tr>
                                @endif
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

@section('scripts')
<script type="text/javascript" src="{{ url('js/plugins/bootstrap/bootstrap-select.js') }}"></script>
<script type="text/javascript">
    function showModal(id) {
        $("#form_add_revision_request_number").attr("action", "/access-requests/" + id + "/grant");
        $("#modal_change_password").modal();
    }

    function deny_request(id) {
        noty({
            text: 'Are you sure you want to deny his request?',
            layout: 'topRight',
            buttons: [
                {addClass: 'btn btn-success btn-clean', text: 'Yes', onClick: function($noty) {
                    $noty.close();
                    document.getElementById('form-delete' + id).submit();
                    }
                },
                {addClass: 'btn btn-danger btn-clean', text: 'No', onClick: function($noty) {
                    $noty.close();
                    }
                }
            ]
        })
    }

    function revoke_access(id){
        noty({
            text: 'Are you sure you want to revoke his access?',
            layout: 'topRight',
            buttons: [
                {addClass: 'btn btn-success btn-clean', text: 'Yes', onClick: function($noty) {
                    $noty.close();
                    document.getElementById('form-revoke' + id).submit();
                    }
                },
                {addClass: 'btn btn-danger btn-clean', text: 'No', onClick: function($noty) {
                    $noty.close();
                    }
                }
            ]
        })
    }
</script>
@endsection
