@extends('layouts.main')

@section('page-title')
    CPAR Index | eQMS
@endsection

@section('nav-view') active @endsection

@section('page-content')
    <div class="page-content-wrap" style="margin-top: -25px;">
        @if(session('attention'))
            @include('layouts.attention')
        @elseif($errors <> null)
            @include('errors.error-message')
        @endif
        <div class="x-content" >
            <div class="x-content-inner" style="margin-top:-20px; height: 90vh;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="x-block">
                            <div class="x-block-head">
                                <div class="pull-right">
                                    <strong>Legends</strong>: <span class="label label-success">Observation</span>&nbsp;<span class="label label-warning">Minor</span>&nbsp;<span class="label label-danger">Major</span>
                                </div>
                            </div>
                            @include('layouts.filter')
                            <table class="table table-striped" id="cpars-table">
                                <thead>
                                <tr>
                                    <th>Audit Type</th>
                                    <th>CPAR #</th>
                                    <th>RAISED BY</th>
                                    <th>SEVERITY</th>
                                    <th>ISSUED</th>
                                    <th>STATUS</th>
                                    <th with="120">Actions</th>
                                </tr>
                                </thead>
                                <tbody id="cpars-table-body">
                                @include('layouts.table-row-cpars', ['cpar'])
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{ $cpars->links() }}
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
    <script src="{{ url('js/plugins/bootstrap/bootstrap-select.js') }}"></script>
    <script src="{{ url('js/plugins/bootstrap/bootstrap-datepicker.js') }}"></script>

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
            $('#edit' + cparId).attr('action', '/cpars/create-cpar-number/' + cparId);
            $('input:text[name="cpar_number"]').val($('input:text[name="cpar-number-input"]').val());
            $('#edit' + cparId).submit();
        }
		if($('#cpars-table-body').children().length == 0) {
			$('#cpars-table-body').html('<tr><td colspan="6" align="center">No CPAR Available.</td></tr>');
		}
    </script>

    <script>
        disableDetailedSearch();

        $('#quick').on('change', function(){
            if($(this).is(':checked')) {
                disableDetailedSearch();
            }
        });

        $('#detailed').on('change', function(){
            if($(this).is(':checked')) {
                reEnableDetailedSearch();
                $('#search').attr('disabled', 'disabled');
            }
        });

        function disableDetailedSearch() {
            $('select[name="audit_type"]').attr('disabled', 'disabled');
            $('select[name="audit_type"]').selectpicker('refresh');
            $('select[name="branch"]').attr('disabled', 'disabled');
            $('select[name="branch"]').selectpicker('refresh');
            $('select[name="department"]').attr('disabled', 'disabled');
            $('select[name="department"]').selectpicker('refresh');
            $('select[name="severity"]').attr('disabled', 'disabled');
            $('select[name="severity"]').selectpicker('refresh');
            $('input[name="tags"]').attr('disabled', 'disabled');
            $('input[name="created_at"]').attr('disabled', 'disabled');
            $('input[name="updated_at"]').attr('disabled', 'disabled');
            $('#search').removeAttr('disabled');
        }

        function reEnableDetailedSearch() {
            $('select[name="audit_type"]').removeAttr('disabled');
            $('select[name="audit_type"]').selectpicker('refresh');
            $('select[name="branch"]').removeAttr('disabled');
            $('select[name="branch"]').selectpicker('refresh');
            $('select[name="department"]').removeAttr('disabled');
            $('select[name="department"]').selectpicker('refresh');
            $('select[name="severity"]').removeAttr('disabled');
            $('select[name="severity"]').selectpicker('refresh');
            $('input[name="tags"]').removeAttr('disabled');
            $('input[name="created_at"]').removeAttr('disabled');
            $('input[name="updated_at"]').removeAttr('disabled');
        }
    </script>
@endsection
