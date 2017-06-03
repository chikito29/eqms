@extends('layouts.main')

@section('page-title'){{ $document->title }} |eQMS @endsection

@section('nav-document') active @endsection

@section('page-content')
    <div class="page-content-wrap" style="margin-top: -25px;">
        <div class="x-content" style="margin-top:-20px; height: 90vh;">
            <div class="x-content-inner" style="margin-top:-20px;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="x-block">
                            <form class="form-horizontal" action="{{ URL::route('documents.update', $document->id) }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('put') }}
                                <div class="x-block-head">
                                    <h3>Edit Document</h3>
                                    <div class="pull-right">
                                        <button class="btn btn-success"> SAVE </button>
                                    </div>
                                </div>
                                <div class="x-block-content x-todo" style="margin-bottom:20px;">
                                    <div class="x-todo-header">
                                        <div class="form-group">
                                            <label class="col-md-2 col-xs-12 control-label">Document Title</label>
                                            <div class="col-md-8 col-xs-12">
                                                    <input type="text" class="form-control" name="title" value="{{ $document->title }}"/>
                                                @if ($errors->has('title'))
                                                    <span class="help-block successful">
                                                        <strong class="text-danger">{{ $errors->first('title') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 col-xs-12 control-label">Section</label>
                                            <div class="col-md-8 col-xs-12">
                                                <select id="select" name="section-id" class="form-control select" data-live-search="true" >
                                                    @foreach($sections as $section)
                                                        <option value="{{ $section->id }}" @if($section->id == $document->section_id) selected @endif>{{ $section->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @if ($errors->has('section-id'))
                                                <span class="help-block successful">
                                                    <strong class="text-danger">{{ $errors->first('section-id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="x-todo-content" style="padding:40px;">
                                        <div class="form-group">
                                            <div class="col-md-12 col-xs-12">
                                                <textarea class="summernote" name="body">{{ $document->body }}</textarea>
                                            </div>
                                            @if ($errors->has('body'))
                                                <span class="help-block successful">
                                                    <strong class="text-danger">{{ $errors->first('body') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ url('js/plugins/summernote/summernote.js') }}"></script>
<script type="text/javascript" src="{{ url('js/plugins/bootstrap/bootstrap-select.js') }}"></script>
@endsection
