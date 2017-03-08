@extends('./layouts/super-admin')

@section('page-title')Revision Request |eQMS @endsection

@section('nav-actions') active @endsection

@section('page-content')
<div class="page-content-wrap">
    <div class="x-content" >
        <div class="x-content-inner" style="margin-top:-20px;">
            <div class="row">
                <div class="col-md-12">

                    <div class="x-block">
                        <div class="x-block-head">
                            <h3>REVISION REQUESTS</h3>
                            <div class="pull-right">
                                <div class="btn-group">
                                    <a href="#" data-toggle="dropdown" class="btn btn-danger dropdown-toggle">NEW   <span class="caret" style="margin-left: 20px;"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#">Draft</a></li>
                                        <li><a href="{{ route('revision-requests.create') }}">Revision Request</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="x-block-content">
                            <table class="table x-table">
                                <tr>

                                    <th>AUTHOR</th>
                                    <th>REFERENCE DOCUMENT</th>
                                    <th>STATUS</th>
                                    <th>RECOMMENDATION</th>
                                    <th>ACTIONS</th>
                                </tr>
                                @foreach($revisionRequests as $revisionRequest)
                                    <tr>
                                        <td>
                                            <a href="#" class="x-user">
                                                <img src="{{ url('img/no-profile-image.png') }}">
                                                <span>{{ $revisionRequest->author_name }}</span>
                                            </a>
                                            <span>{{ $revisionRequest->created_at->toDayDateTimeString() }}</span>
                                        </td>
                                        <td><a href="#">{{ $revisionRequest->reference_document->title }}</a></td>
                                        <td><span class="label label-info" style="color: white;">new</span></td>
                                        <td><span class="label label-danger" style="color: white;">denied</span></td>
                                        <td><button class="btn btn-info btn-rounded btn-condensed btn-sm" onclick="location.href = '{{ route('revision-requests.show', $revisionRequest->id) }}';">View</button></td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>

                    <ul class="pagination pagination-sm push-up-20">
                        <li class="disabled"><a href="#">Previous</a></li>
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li><a href="#">Next</a></li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
