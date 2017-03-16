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
                                    <th>QMR</th>
                                    <th>CEO</th>
                                    <th>ACTIONS</th>
                                </tr>
                                @foreach($revisionRequests as $revisionRequest)
                                    <tr>
                                        <td>
                                            <a href="#" class="x-user">
                                                <img src="{{ url('img/no-profile-image.png') }}">
                                                <span>{{ $revisionRequest->user_name }}</span>
                                            </a>
                                            <span>{{ $revisionRequest->created_at->toDayDateTimeString() }}</span>
                                        </td>
                                        <td><a href="{{ route('documents.show', $revisionRequest->reference_document->id) }}" target="_blank">{{ $revisionRequest->reference_document->title }}</a></td>
                                        @if($revisionRequest->status == 'New')
                                        <td><span class="label label-info" style="color: white;">{{ $revisionRequest->status }}</span></td>
                                        @elseif($revisionRequest->status == 'Processing')
                                        <td><span class="label label-warning" style="color: white;">{{ $revisionRequest->status }}</span></td>
                                        @elseif($revisionRequest->status == 'Done')
                                        <td><span class="label label-default" style="color: white;">{{ $revisionRequest->status }}</span></td>
                                        @else
                                        <td><span class="label label-danger" style="color: white;">{{ $revisionRequest->status }}</span></td>
                                        @endif

                                        @if($revisionRequest->section_b)
                                            @if($revisionRequest->section_b->recommendation_status == 'For Approval')
                                                <td><span class="label label-success" style="color: white;">{{ $revisionRequest->section_b->recommendation_status }}</span></td>
                                            @else
                                                <td><span class="label label-danger" style="color: white;">{{ $revisionRequest->section_b->recommendation_status }}</span></td>
                                            @endif
                                        @else
                                            <td></td>
                                        @endif

                                        @if($revisionRequest->section_c)
                                            @if($revisionRequest->section_c->approved)
                                                <td><span class="label label-success" style="color: white;">Approved</span></td>
                                            @else
                                                <td><span class="label label-danger" style="color: white;">Denied</span></td>
                                            @endif
                                        @else
                                            <td></td>
                                        @endif

                                        <td>
                                            <a href="{{ route('revision-requests.show', $revisionRequest->id) }}" class="btn btn-default btn-rounded btn-condensed btn-sm"><span class="fa fa-eye"></span> View</button>
                                            @if($revisionRequest->section_b)
                                            @if($revisionRequest->section_b->recommendation_status == 'For Approval')
                                            <a href="{{ route('revision-requests.print', $revisionRequest->id) }}" class="btn btn-default btn-rounded btn-condensed btn-sm" target="_blank" style="margin-left: 4px;"><span class="fa fa-print"></span> Print</a>
                                            @endif
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>

                    {{ $revisionRequests->links() }}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
