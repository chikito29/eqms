@extends('./layouts/super-admin')

@section('page-title'){{ $document->title }} | eQMS @endsection

@section('nav-document') active @endsection

@section('page-content')
    <div class="row" style="margin-bottom: 30px;">

        <div class="col-md-9">
            <div class="x-content" style="min-height: 90vh;">

                <div class="x-content-title" style="margin-bottom:60px;">
                    <h1 class="text-warning">{{ $document->title }}</h1>
                    <div class="pull-right">
                        <button class="btn btn-default btn-condensed" onclick="location.href = '{{ route('revision-requests.create') . '?reference_document=' . $document->id }}';"><i class="fa fa-pencil"></i></button>
                        <button class="btn btn-default btn-condensed" onclick="location.href = '{{ route('documents.edit', $document->id) }}';"><i class="glyphicon glyphicon-edit"></i></button>
                        <button class="btn btn-default btn-condensed" onclick="delete_document({{ $document->id }})"><i class="glyphicon glyphicon-trash"></i></button>
                        <form class="form-horizontal" action="{{ route('documents.destroy', $document->id) }}" method="post" id="form-delete{{ $document->id }}">
                             {{ csrf_field() }}
                             {{ method_field('delete') }}
                         </form>
                    </div>
                </div>

                <div class="x-block-content">
                    <div class="tocify-content document" style="padding:50px;">
                        {!! $document->body !!}
                    </div>
                </div>

            </div>
        </div>

        <div class="col-md-3" style="position: relative; ">
            <div id="tocify"></div>
        </div>

    </div>
@endsection

@section('message-box')
    <!-- MESSAGE BOX-->
    <div class="message-box animated fadeIn" data-sound="alert" id="mb-remove-document">
        <div class="mb-container">
            <div class="mb-middle">
                <div class="mb-title"><span class="fa fa-times"></span> Remove <strong>Document</strong> ?</div>
                <div class="mb-content">
                    <p>Are you sure you want to remove this document?</p>
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
    <script type="text/javascript" src="{{ url('js/plugins/tocify/jquery.tocify.min.js') }}"></script>

    <script>
        function delete_document(row){
            var box = $('#mb-remove-document');
            box.addClass("open");
            box.find(".mb-control-yes").on("click",
                function(){
                    box.removeClass("open");
                    document.getElementById('form-delete' + row).submit();
                }
            );
        }

        function edit_document(row){
            document.getElementById('form-edit' + row).submit();
        }

        $(function () {
            var toc = $("#tocify").tocify({
                context: ".tocify-content",
                showEffect: "fadeIn",
                extendPage: false,
                selectors: "h2, h3, h4, h5"
            });
        });
    </script>
@endsection
