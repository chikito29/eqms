@extends('layouts.super-admin')

@section('page-title')
    Home | Cpar Index
@endsection

@section('nav-audit-findings') active @endsection

@section('page-content')
    <div class="page-content-wrap" style="margin-top: -25px;">
        <div class="x-content" >
            <div class="x-content-inner" style="margin-top:-20px;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="x-block">
                            <div class="x-block-head">
                                <h3>CPAR List</h3>
                            </div>
                            <table class="table table-striped" id="table-application">
                                    <thead>
                                    <tr>
                                        <th>CPAR #</th>
                                        <th>RAISED BY</th>
                                        <th>SEVERITY</th>
                                        <th>ISSUED</th>
                                        <th>STATUS</th>
                                        <th with="120">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($cpars as $cpar)
                                        <tr>
                                            <td>{{ $cpar->cpar_number }}</td>
                                            <td>{{ $cpar->raised_by }}</td>
                                            <td>{!! $cpar->severity !!}</td>
                                            <td>{{ $cpar->created_at->toDayDateTimeString() }}</td>
                                            <td>
                                                @if($cpar->cparClosed->status == 1) <span class="label label-primary">Closed {{ $cpar->cparClosed->created_at->diffForHumans() }}</span>
                                                @elseif($cpar->cparReviewed->on_review == 1) <span class="label label-warning">Closed {{ $cpar->cparReviewed->updated_at->diffForHumans() }}</span>
                                                @elseif($cpar->cparAnswered->status == 1 && $cpar->cparReviewed->status == 1) <span class="label label-success">Reviewed {{ $cpar->cparReviewed->created_at->diffForHumans() }}</span>
                                                @elseif($cpar->cparAnswered->status <> 1) <span class="label label-danger">No Response. Issued {{ $cpar->created_at->diffForHumans() }}</span>
                                                @else <span class="label label-success">CPAR answered {{ $cpar->cparAnswered->created_at->diffForHumans() }}</span>
                                                @endif
                                            </td>
                                            <td width="360px">
                                                <button class="btn btn-default btn-rounded btn-sm" onclick="location.href='{{ route('cpars.show', $cpar->id) }}';"><span class="fa fa-share"> view</span></button>
                                                <button class="btn btn-default btn-rounded btn-sm" onclick="location.href='{{ route('cpars.edit', $cpar->id) }}';" @if($cpar->cparAnswered->status == 1) disabled="disabled" @endif><span class="fa fa-pencil"> edit</span></button>
                                                <button class="btn btn-info btn-rounded btn-sm" onclick="location.href='{{ route('review', $cpar->id) }}';" @if($cpar->cparAnswered->status <> 1) disabled="disabled" @endif><span class="fa fa-legal"> review</span></button>
                                                <button class="btn btn-primary btn-rounded btn-sm" onclick="close_cpar({{ $cpar->id }})"><span class="fa fa-times"> close</span></button>
                                            </td>
                                            <form method="POST" action="{{ route('cpars.destroy', $cpar->id) }}" accept-charset="UTF-8" id="form-delete{{ $cpar->id }}">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                            </form>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('message-box')
    <!-- MESSAGE BOX-->
    <div class="message-box animated fadeIn" data-sound="alert" id="mb-remove-cpar">
        <div class="mb-container">
            <div class="mb-middle">
                <div class="mb-title"><span class="fa fa-times"></span> Remove <strong>Cpar</strong> ?</div>
                <div class="mb-content">
                    <p>Are you sure you want to remove this Cpar?</p>
                    <p>Documents belong to this Cpar will not be available</p>
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

    <div class="modal fade" id="confirm-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Confirm Action</h4>
                </div>
                <div class="modal-body" id="modal-body">
                    CPAR is not yet <span class="text text-info">REVIEWED</span>, are you sure you want it to be <span class="text text-danger">CLOSED</span>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Yes, Close issued CPAR</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@section('scripts')
    <script>
        function close_cpar(cpar){
            @if($cpar->cparReviewed->status == 0) $('#confirm-modal').modal('toggle');
            @elseif($cpar->cparReviewed->status == 1) $('#modal-body').empty().append("Are you sure you want to <span class=\"text text-warning\">CLOSE</span>");
            @endif
        }

        function edit_document(row){
            document.getElementById('form-edit' + row).submit();
        }
    </script>
@endsection
