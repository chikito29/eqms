@extends('layouts.main')

@section('page-title')
    Home | Cpar Index
@endsection

@section('nav-audit-findings') active @endsection

@section('page-content')
    <div class="page-content-wrap" style="margin-top: -25px;">
        @if(session('attention'))
            @include('layouts.attention')
        @endif
        <div class="x-content" >
            <div class="x-content-inner" style="margin-top:-20px; height: 90vh;">
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
                                            <td>
                                                @foreach($employees as $employee)
                                                    @if($employee->id == $cpar->raised_by)
                                                        {{ $employee->first_name }} {{ $employee->last_name }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{!! $cpar->severity !!}</td>
                                            <td>{{ $cpar->created_at->toDayDateTimeString() }}</td>
                                            <td>
                                                @include('components.status', compact('cpar'))
                                            </td>
                                            <td>
                                                @component('components.button-state', compact('cpar')) @slot('title') view @endslot view @endcomponent
                                                @component('components.button-state', compact('cpar')) @slot('title') edit @endslot edit @endcomponent
                                                @if($cpar->cparReviewed->status == 1 && $cpar->cpar_number == null)
                                                    @component('components.button-state', compact('cpar')) @slot('title') Create CPAR Number @endslot Create CPAR Number @endcomponent
                                                @elseif($cpar->cparReviewed->status == 1 && $cpar->cpar_number <> null)
                                                    @component('components.button-state', compact('cpar')) @slot('title') Print Reviewed CPAR @endslot Print Reviewed CPAR @endcomponent
                                                @elseif($cpar->cparReviewed->status == 0 && $cpar->cpar_number == null)
                                                    @component('components.button-state', compact('cpar')) @slot('title') Print Closed CPAR @endslot Print Closed CPAR @endcomponent
                                                @else
                                                    @component('components.button-state', compact('cpar')) @slot('title') review @endslot review @endcomponent
                                                @endif
                                                @component('components.button-state', compact('cpar')) @slot('title') close @endslot close @endcomponent
                                            </td>
                                            <form method="get" id="edit{{ $cpar->id }}"><input type="text" class="form-control hidden" name="cpar_number"></form>
                                            <form method="get" action="{{ route('cpars.close', $cpar->id) }}" accept-charset="UTF-8" id="close{{ $cpar->id }}">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                                <input type="text" class="form-control hidden" name="cpar_id">
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
                    Are you sure you want to <span class="text text-danger">close</span> CPAR?
                </div>
                <div class="modal-footer" id="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="modal-yes">Yes, Close issued CPAR</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@section('modals')
    <div class="modal fade" id="cpar-number-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Create CPAR Number</h4>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control" name="cpar-number-input" required>
                    <span class="help text text-info">Enter the CPAR control number here.</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveCparNumber()" id="savebtn-modal">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop

@section('scripts')
    <script>
        var confirmModalBody;
        cparId = '';

        $(function(){
            confirmModalBody = $('#confirm-modal').html();
        });

        function closeCpar(id){
            var cparId = id;
            $('#modal-yes').attr('onclick', '$("'+ "#close" + cparId + '").submit();');
            $('input:text[name="cpar_id"]').val(id);
            $('#confirm-modal').modal('toggle');
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

        function openCparNumberModal(id) {
            cparId = id;
            $('#cpar-number-modal').modal('toggle');
        }

        function saveCparNumber() {
            $('#' + cparId).attr('action', '/cpars/create-cpar-number/' + cparId);
            $('input:text[name="cpar-number"]').val($('input:text[name="cpar-number-input"]').val());
            $('#' + cparId).submit();
        }
    </script>
@endsection
