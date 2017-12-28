@extends('layouts.main')

@section('page-title')Search |eQMS @endsection

@section('nav-document') active @endsection

@section('page-content')
    <div class="page-content-wrap">

        <div class="row">
            <div class="col-md-12">

                <!-- START SEARCH RESULT -->
                <div class="search-results">
                    @if($documents->count() > 0)
                        @foreach($documents as $document)
                            <div class="sr-item">
                                <a href="{{ URL::to('documents/' . $document->id) }}?search={{ request('search') }}" class="sr-item-title">{{ $document->title }}</a>
                                <div class="sr-item-link">{{ URL::to('documents/' . $document->id) }}</div>
                                <p class="limit">	{!!
                                            substr(
                                                ucfirst(
                                                    str_replace( request('search'), '<mark style="background-color: yellow;">' .request('search'). '</mark>', substr(strip_tags(strtolower($document->body)), strpos(strip_tags(strtolower($document->body)), request('search')), 400))
                                                    ), 0, 400) !!}	</p>

                                <p class="sr-item-links"><a href="{{ URL::to('documents/' . $document->id) }}?search={{ request('search') }}" target="_new">Open in new window</a> </p>
                            </div>
                        @endforeach
                    @else
                        <div class="sr-item">
                            <a href="#" class="sr-item-title align">No result found for keyword <mark>{{ request('search') }}</mark></a>
                        </div>
                    @endif
                </div>
                <!-- END SEARCH RESULT -->
                @if($documents->count() > 0)
                    {{ $documents->appends(['search' => request('search')])->links() }}
                @endif
            </div>
        </div>

    </div>
@endsection
