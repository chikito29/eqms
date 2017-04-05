@extends('layouts/super-admin')

@section('page-title')
    Sections | eQMS
@endsection

@section('nav-actions') active @endsection

@section('page-content')
    <div class="page-content-wrap" style="margin-top: -25px;">
        <div class="x-content" >
            <div class="x-content-inner" style="margin-top:-20px; height: 90vh;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="x-block">
                            <div class="x-block-head">
                                <h3>New Section</h3>
                            </div>
                            <div class="x-block-content x-todo" style="margin-bottom: 20px;">
                                <div class="x-todo-header">
                                    <form class="form-horizontal" action="{{ route('sections.store') }}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label class="col-md-2 col-xs-12 control-label">Section Name</label>
                                            <div class="col-md-6 col-xs-12">
                                                <input type="text" class="form-control" name="name" style="margin-top:7px;"/>
                                                @if ($errors->has('name'))
                                                    <span class="help-block successful">
                                                        <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-md-2">
                                                <button class="btn btn-success"> SAVE</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <table class="table table-striped" id="table-application">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Added By</th>
                                            <th>Last Updated</th>
                                            <th with="120">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sections as $section)
                                            <tr>
                                                <td>{{ $section->id }}</td>
                                                <td>{{ $section->name }}</td>
                                                <td>{{ $section->created_by }}</td>
                                                <td>{{ $section->updated_at->toDayDateTimeString() }}</td>
                                                <td>
                                                    <button class="btn btn-default btn-rounded btn-sm" onclick="location.href='{{ route('sections.edit', $section->id) }}';"><span class="fa fa-pencil"></span></button>
                                                    <button class="btn btn-danger btn-rounded btn-sm" type="button" name="button" onclick="delete_section({{ $section->id }})"><span class="fa fa-times"></span></button>
                                                </td>
                                                <form method="POST" action="{{ route('sections.destroy', $section->id) }}" accept-charset="UTF-8" id="form-delete{{ $section->id }}">
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
    <div class="message-box animated fadeIn" data-sound="alert" id="mb-remove-section">
        <div class="mb-container">
            <div class="mb-middle">
                <div class="mb-title"><span class="fa fa-times"></span> Remove <strong>Section</strong> ?</div>
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
<script>
    function delete_section(row){
        var box = $('#mb-remove-section');
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
</script>
@endsection
