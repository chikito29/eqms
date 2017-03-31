@extends('cpars.show')

@section('modals')
    <a class="btn btn-primary hidden" data-toggle="modal" href="#verify-cpar" id="verify-cpar-modal-trigger">Trigger modal</a>
    <div class="modal fade" id="verify-cpar">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Confirm Action</h4>
                </div>
                <div class="modal-body">
                    After verifying this cpar, responsible person under your department will not be able to make anymore
                    changes.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="submitFinalizedCpar()">Verify</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop

@section('scripts')
    <script>
        $(function() {
            $('#print-cpar').attr('onclick', 'verifyCpar()');
            $('#print-cpar').html('Verify CPAR');
        });

        function verifyCpar() {
            $('#verify-cpar-modal-trigger').click();
        }

        function submitFinalizedCpar() {
            $('#form-cpar').attr('action', '{{ route('cpars.finalize', $cpar->id) }}');
            $('#form-cpar').submit();
        }
    </script>

    <script type="text/javascript" src="{{ url('js/plugins/summernote/summernote.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/plugins/bootstrap/bootstrap-select.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $('#summernote').summernote({
                height: 300,
                toolbar: [
                    ['misc', ['fullscreen']]
                ],
            });
        });
    </script>
@stop