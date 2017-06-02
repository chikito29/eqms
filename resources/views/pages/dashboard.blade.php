@extends('layouts.main')

@section('page-title')
    Dashboard | eQMS
@endsection

@section('nav-home') active @endsection

@section('page-content')
    <div class="x-content-tabs">
        <ul>
            <li><a href="#main-tab" class="icon active"><span class="fa fa-desktop"></span></a></li>
        </ul>
    </div>
    <div class="x-content">
        <div id="main-tab">
            <div class="x-content-title">
                <h1>Dashboard</h1>
            </div>
            <div class="row stacked">
                <div class="col-md-10">
                    <div class="x-chart-widget">
                        <div class="x-chart-widget-head">
                            <div class="x-chart-widget-title">
                                <h3>eQMS Activity</h3>
                                {{--<p>Account Type: <span>Business</span></p>--}}
                            </div>
                            <div class="pull-right">
                                <strong>Legend: </strong> <span class="label label-danger">CPARS</span> <span class="label label-success">Revision Requests</span>
                            </div>
                        </div>
                        <div class="x-chart-widget-content">
                            <div class="x-chart-widget-content-head">
                                <h4>SUMMARY</h4>
                                <div class="pull-right">
                                    <div class="btn-group">
                                        <button class="btn btn-default">MONTH</button>
                                        <button class="btn btn-default">YEAR</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="x-chart-widget-informer">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="x-chart-widget-informer-item">
                                                    <div class="count">{{ $cparsOld->count() }}</div>
                                                    <div class="title">Last year's CPAR count</div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="x-chart-widget-informer-item">
                                                    <div class="count">{{ $cparsNew->count() }}<span>{{ $cparsNew->count() - $cparsOld->count() / $cparsOld->count() }}% <i class="fa fa-arrow-up"></i></span></div>
                                                    <div class="title">This year's CPAR count</div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="x-chart-widget-informer-item">
                                                    <div class="count">{{ $revisionRequestsOld->count() }}</div>
                                                    <div class="title">Last year's revision requests count</div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="x-chart-widget-informer-item last">
                                                    <div class="count">{{ $revisionRequestsNew->count() }}<span>{{ $revisionRequestsNew->count() - $revisionRequestsOld->count() / $revisionRequestsOld->count() }}% <i class="fa fa-arrow-up"></i></span></div>
                                                    <div class="title">This year's revision requests count</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="x-chart-holder">
                                <div id="x-dashboard-line" style="height: 400px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">

                    <div class="x-widget-timeline">
                        <div class="x-widget-timelime-head">
                            <h3>NOTIFICATIONS</h3>
                        </div>
                        <div class="x-widget-timeline-content">
                           @if($newlyCreatedCpars->count() > 0)
                                @foreach($newlyCreatedCpars as $cpar)
                                    <div class="item item-blue">
                                        a new <a href="{{ route('cpars.review', $cpar->id) }}">CPAR</a> has been <strong>created</strong>
                                        <span>{{ \Carbon\Carbon::parse($cpar->created_at)->diffForHumans() }}</span>
                                    </div>
                                @endforeach
                           @else
                               No new notifications available!
                           @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type='text/javascript' src='/js/plugins/icheck/icheck.min.js'></script>
    <script type="text/javascript" src="{{ url('js/plugins/morris/raphael-min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/plugins/morris/morris.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            /* Line dashboard chart */
            Morris.Line({
              element: 'x-dashboard-line',
              data: [
                @foreach($chartData as $data)
                { y: '{{ $data->day }}', a: '{{ $data->revision_request }}'},
                @endforeach
				@foreach($chartDataCpar as $data)
                { y: '{{ $data->day }}', b: '{{ $data->cpar }}'},
                @endforeach
              ],
              xkey: 'y',
              ykeys: ['a','b'],
              labels: ['Revision Request','CPAR'],
              resize: true,
              pointSize: '8px',
              pointStrokeColors: '#DEE4EC',
              xLabels: 'day',
              gridTextSize: '11px',
              lineColors: ['#95B75D','#E34724'],
              gridLineColor: '#95ABBB',
              gridTextColor: '#95ABBB',
              gridTextWeight: 'bold'
            });
            /* EMD Line dashboard chart */
        });
    </script>
@endsection
