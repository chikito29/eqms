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
                                                @include('components.status', compact('cpar'))
                                            </td>
                                            <td width="360px">
                                                @component('components.button-state', compact('cpar')) @slot('title') view @endslot view @endcomponent
                                                @component('components.button-state', compact('cpar')) @slot('title') edit @endslot edit @endcomponent
                                                @component('components.button-state', compact('cpar')) @slot('title') review @endslot review @endcomponent
                                                @component('components.button-state', compact('cpar')) @slot('title') close @endslot close @endcomponent
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
    <div class="modal fade" id="confirm-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="modal-title">Close CPAR</h4>
                </div>
                <div class="modal-body" id="modal-body">
                    CPAR is not yet <span class="text text-info">REVIEWED</span>, are you sure you want it to be <span class="text text-danger">CLOSED</span>?
                </div>
                <div class="modal-footer" id="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="modal-yes">Yes, Close issued CPAR</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@section('scripts')
    <script>
        var confirmModalBody;

        $(function(){
            confirmModalBody = $('#confirm-modal').html();
        });

        function closeCpar(){
            @if($cpar->cparReviewed->status == 0)
                $('#confirm-modal').empty().append(confirmModalBody);
                $('#modal-yes').attr('onclick', 'close()');
                $('#confirm-modal').modal('toggle');
            @elseif($cpar->cparReviewed->status == 1)
                $('#modal-title').empty().append('Close CPAR?');
                $('#modal-body').empty().append("Are you sure you want to <span class=\"text text-warning\">CLOSE</span>");
                $('#confirm-modal').modal('toggle');
            @endif
        }

        function checkButton(date, url){

            if(date == ""){
                $('#modal-title').empty().append('Attention');
                $('#modal-body').empty().append('Cpar has not yet been reviewed and confirmed by concerned person\'s department head');
                $('#modal-footer').empty().append('<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>');
                $('#confirm-modal').modal('toggle');
            }
            else
                window.location.href= url;
        }
    </script>
@endsection
