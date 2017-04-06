@extends('layouts.main')

@section('page-title')
    Settings
@endsection

@section('page-content')
    <div class="page-content-wrap" style="margin-top: -25px;">
        @if(session('attention'))
            @include('layouts.attention')
        @endif
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
                                    <th>Added By</th>
                                    <th>Full Name</th>
                                    <th>Role</th>
                                    <th>Branch</th>
                                    <th with="120">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($eqmsUsers as $user)
                                        <tr>
                                            <td>{{ $user->added_by }}</td>
                                            <td>{{ $user->fullname }}</td>
                                            <td>{{ $user->role }}</td>
                                            <td>{{ $user->branch }}</td>
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