@extends('layouts.main')

@section('page-title')Search |eQMS @endsection

@section('nav-document') active @endsection

@section('page-content')
    <div class="page-content-wrap">

        <div class="row">
            <div class="col-md-12">

                <!-- START SEARCH RESULT -->
                <div class="search-results">

                    @foreach($documents as $document)
                        <div class="sr-item">
                            <a href="{{ URL::to('documents/' . $document->id) }}" class="sr-item-title">{{ $document->title }}</a>
                            <div class="sr-item-link">{{ URL::to('documents/' . $document->id) }}</div>
                            <p class="limit">	{!!
                            			substr(
                            				ucfirst(
                            					str_replace( request('search'), '<mark>' .request('search'). '</mark>', substr(strip_tags(strtolower($document->body)), strpos(strip_tags(strtolower($document->body)), request('search')), 400))
                            					), 0, 400) !!}	</p>

                            <p class="sr-item-links"><a href="{{ URL::to('documents/' . $document->id) }}?search={{ request('search') }}" target="_new">Open in new window</a> </p>
                        </div>
                    @endforeach

                </div>
                <!-- END SEARCH RESULT -->

                <ul class="pagination pagination-sm pull-right push-down-20">
                    <li class="disabled"><a href="#">«</a></li>
                    <li class="active"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">»</a></li>
                </ul>

            </div>
        </div>

    </div>
@endsection
