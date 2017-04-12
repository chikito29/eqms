<div class="x-hnavigation no-print" style="margin-bottom: 30px;">
    <div class="x-hnavigation-logo">
        <a href="{{ url('/') }}">eQMS</a>
    </div>
    <ul>
        <li class="@yield('nav-home')">
            <a href="{{ route('pages.dashboard') }}">Dashboard</a>
        </li>
        <li class="xn-openable @yield('nav-document')">
            <a href="#">Procedures</a>
            <ul>
                @foreach($sections as $section)
                    <li class="xn-openable">
                        <a href="#"><span class="fa fa-circle"></span> {{ $section->name }}</a>
                        <ul>
                            @foreach($section->documents as $document)
                                <li><a href="{{ route('documents.show', $document->id) }}">{{ $document->title }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </li>
        <li class="xn-openable @yield('nav-view')">
            <a href="#">View</a>
            <ul>
                <li><a href="{{ route('revision-requests.index') }}"><span class="fa fa-paste"></span> Revision Requests</a></li>
                <li><a href="{{ route('cpars.index') }}"><span class="fa fa-envelope-o"></span> CPAR Forms</a></li>
                <li><a href="#"><span class="fa fa-files-o"></span> Revision Logs</a></li>
            </ul>
        </li>
        <li class="xn-openable @yield('nav-actions')">
            <a href="#">Actions</a>
            <ul>
                <li><a href="{{ route('cpars.create') }}"><span class="fa fa-pencil-square-o"></span> Create CPAR</a></li>
            </ul>
        </li>
    </ul>

    <div class="x-features">
        <div class="x-features-nav-open">
            <span class="fa fa-bars"></span>
        </div>
        <div class="pull-right">
            <div class="x-features-search @if(request('search')) active @endif">
                <form class="form-horizontal" action="{{ route('documents.index') }}" method="get">
                    <input type="text" name="search" value="@if(request('search')){{ request('search') }}@endif">
                    <input type="submit">
                </form>
            </div>
            <div class="x-features-profile">
                <img src="{{ url('img/no-profile-image.png') }}">
                <ul class="xn-drop-left animated zoomIn">
                    <li><a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span> Sign Out</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
