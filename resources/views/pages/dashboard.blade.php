@extends('layouts.main')

@section('page-title')
    Dashboard | eQMS
@endsection

@section('nav-home') active @endsection

@section('page-content')
    <div class="x-content-tabs">
        <ul>
            <li><a href="#main-tab" class="icon active"><span class="fa fa-desktop"></span></a></li>
            <li><a href="#second-tab"><span class="fa fa-life-ring"></span><span>Second tab</span></a></li>
            <li><a href="#third-tab"><span class="fa fa-microphone"></span><span>Third tab</span></a></li>
            <li><a href="#new-tab" class="icon"><span class="fa fa-plus"></span></a></li>
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
                                <button class="btn btn-default">EXPORT</button>
                                <button class="btn btn-default">TODAY: 14 SEP.2015</button>
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
                                                    <div class="count">223<span>34% <i class="fa fa-arrow-up"></i></span></div>
                                                    <div class="title">Views of your profile</div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="x-chart-widget-informer-item">
                                                    <div class="count">190<span>17% <i class="fa fa-arrow-up"></i></span></div>
                                                    <div class="title">Views of your works</div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="x-chart-widget-informer-item">
                                                    <div class="count">223<span class="negative">22% <i class="fa fa-arrow-down"></i></span></div>
                                                    <div class="title">Likes</div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="x-chart-widget-informer-item last">
                                                    <div class="count">160<span>3% <i class="fa fa-arrow-up"></i></span></div>
                                                    <div class="title">Comments</div>
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
                            <div class="pull-right"><a href="#">Settings <span class="fa fa-cog"></span></a></div>
                        </div>
                        <div class="x-widget-timeline-content">
                            <div class="item item-blue">
                                <a href="#">Maria Jackson</a> Sent you a <strong>message</strong>
                                <span>3 minutes ago</span>
                            </div>
                            <div class="item item-green">
                                <a href="#">Brian Dawson</a> Invited you to <strong>Linkedin</strong>
                                <span>16.09.2015 1:27 pm</span>
                            </div>
                            <div class="item item-green">
                                <a href="#">Hannah Jensen</a> Invited you to like her on <strong>facebook</strong>
                                <span>16.09.2015 1:13 pm</span>
                            </div>
                            <div class="item item-red">
                                <a href="#">Nancy Watson</a> You got 3 new <strong>notifications</strong>
                                <span>16.09.2015 11:41 am</span>
                            </div>
                            <div class="item item-red">
                                <a href="#">Nancy Watson</a> You got 1 requests to <strong>add friends</strong>
                                <span>16.09.2015 11:23 am</span>
                            </div>
                            <div class="item item-greay">
                                <a href="#">Hannah Jensen</a> Invited you to like her on <strong>facebook</strong>
                                <span>16.09.2015 10:26 am</span>
                            </div>
                            <div class="item item-blue">
                                <a href="#">Douglas Cook</a> Sent you a <strong>message</strong>
                                <span>16.09.2015 09:15 am</span>
                            </div>
                            <button class="btn btn-default btn-block">Load more...</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div id="second-tab"></div>
        <div id="third-tab"></div>
        <div id="fourth-tab"></div>
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
