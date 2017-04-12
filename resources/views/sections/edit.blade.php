@extends('layouts.main')

@section('page-title')
    Procedures | eQMS
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
                                <h3>Edit Procedure</h3>
                            </div>
                            <div class="x-block-content x-todo" style="margin-bottom: 20px;">
                                <div class="x-todo-header">
                                    <form class="form-horizontal" action="{{ route('sections.update', $section->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('put') }}
                                        <div class="form-group">
                                            <label class="col-md-2 col-xs-12 control-label">Old Procedure Name</label>
                                            <div class="col-md-6 col-xs-12">
                                                <input type="text" class="form-control" style="margin-top:7px;" value="{{ $section->name }}" disabled/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 col-xs-12 control-label">New Name</label>
                                            <div class="col-md-6 col-xs-12">
                                                <input type="text" class="form-control" name="name" style="margin-top:7px;"/>
                                                @if ($errors->has('name'))
                                                    <span class="help-block successful">
                                                        <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-md-2">
                                                <button class="btn btn-success"> UPDATE</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
