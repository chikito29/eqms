<div class="x-hnavigation no-print" style="margin-bottom: 30px;">
    <div class="x-hnavigation-logo">
        <a href="{{ url('/') }}">eQMS</a>
    </div>
    <ul>
        <li class="active">
            <a href="#">CPAR issued
                <strong class="text text-warning">{{ $cpar->created_at->diffForHumans() }}</strong>,
                Please answer the CPAR on or before
                <strong class="text text-warning">{{ $dueDate->toFormattedDateString() }}</strong>
            </a>
        </li>
    </ul>

    <div class="x-features">
        <div class="x-features-nav-open">
            <span class="fa fa-bars"></span>
        </div>
        <div class="pull-right">
            <div class="x-features-profile">
                <img src="{{ url('img/no-profile-image.png') }}">
                <ul class="xn-drop-left animated zoomIn">
                    <li><a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span> Sign Out</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>