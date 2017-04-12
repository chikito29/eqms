@extends('layouts.main')

@section('page-title')Revision Request | eQMS @endsection

@section('nav-view') active @endsection

@section('page-content')
<div class="page-content-wrap">

    <div class="x-content" >
        <div class="x-content-inner" style="margin-top:-45px; height: 90vh;">

            <div class="row">
                <div class="col-md-12">

                    <div class="x-block">
                        <div class="x-block-head">
                            <h3>REVISION REQUESTS</h3>
                        </div>
                        <div class="x-block-content">
                            <table class="table x-table">
                                <tr>
                                    <th>AUTHOR</th>
                                    <th>REVISION REQUEST NO.</th>
                                    <th>REFERENCE DOCUMENT</th>
                                    <th>STATUS</th>
                                    <th>QMR</th>
                                    <th>CEO</th>
                                    <th>ACTIONS</th>
                                </tr>
                                @foreach($revisionRequests as $revisionRequest)
                                    <tr>
                                        <td>
                                            <a href="#" class="x-user"><img src="{{ url('img/no-profile-image.png') }}"><span>{{ $revisionRequest->user_name }}</span></a><span>{{ $revisionRequest->created_at->toDayDateTimeString() }}</span>
                                        </td>
                                        <td><p><b>{{ $revisionRequest->revision_request_number }}</b></p></td>
                                        <td><a href="{{ route('documents.show', $revisionRequest->reference_document->id) }}" target="_blank">{{ $revisionRequest->reference_document->title }}</a></td>
                                        <td>
                                            @component('components.label-revision-request-status') {{ $revisionRequest->status }} @endcomponent
                                        </td>
                                        <td>
                                            @if($revisionRequest->section_b)
                                                @component('components.label-revision-request-qmr') {{ $revisionRequest->section_b->recommendation_status }} @endcomponent
                                            @endif
                                        </td>
                                        <td>
                                            @if($revisionRequest->section_c)
                                                @component('components.label-revision-request-ceo') {{ $revisionRequest->section_c->approved }} @endcomponent
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('revision-requests.show', $revisionRequest->id) }}" class="btn btn-default btn-rounded btn-condensed btn-sm"><span class="fa fa-eye"></span> View</button>
                                            @if($revisionRequest->revision_request_number)
                                            <a href="{{ route('revision-requests.print', $revisionRequest->id) }}" class="btn btn-default btn-rounded btn-condensed btn-sm" target="_blank" style="margin-left: 4px;"><span class="fa fa-print"></span> Print</a>
                                            @elseif($revisionRequest->section_d)
                                            <a href="#" class="btn btn-danger btn-rounded btn-condensed btn-sm" onclick="showModal({{ $revisionRequest->id }}); return false;" style="margin-left: 4px;"><span class="fa fa-plus" style="color: rgb(180, 70, 69)"></span> Revision Request No.</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>

                    {{ $revisionRequests->links() }}

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
                        <label class="col-md-3 control-label">Request Number</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="revision_request_number">
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
<script type="text/javascript">
    function showModal(id) {
        $("#form_add_revision_request_number").attr('action', "/revision-requests/" + id);
        $("#modal_change_password").modal();
    }
</script>
@endsection
