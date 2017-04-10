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
                <div class="pull-right">
                    <button class="btn btn-danger"><span class="fa fa-plus"></span> ADD NEW WIDGET</button>
                </div>
            </div>
            <div class="row stacked">
                <div class="col-md-10">
                    <div class="x-chart-widget">
                        <div class="x-chart-widget-head">
                            <div class="x-chart-widget-title">
                                <h3>eQMS Activity</h3>
                                <p>Account Type: <span>Business</span></p>
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
                                        <button class="btn btn-default">DAY</button>
                                        <button class="btn btn-primary">WEEK</button>
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

            <div class="x-content-inner">
                <div class="row">
                    <div class="col-md-8">

                        <div class="x-block">
                            <div class="x-block-head">
                                <h3>COMMENTS</h3>
                                <div class="pull-right">
                                    <button class="btn btn-default">ACTIONS <span class="fa fa-angle-down" style="margin-left: 20px;"></span></button>
                                </div>
                            </div>
                            <div class="x-block-content">
                                <table class="table x-table">
                                    <tr>
                                        <th width="200px;">AUTHOR</th>
                                        <th>REFERENCE DOCUMENT</th>
                                        <th>REASON FOR REVISION </th>
                                        <th>STATUS</th>
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
                                        <td>{{ $revisionRequest->revision_reason }}</td>
                                        @if($revisionRequest->status == 'New')
                                        <td><span class="label label-info" style="color: white;">{{ $revisionRequest->status }}</span></td>
                                        @elseif($revisionRequest->status == 'Processing')
                                        <td><span class="label label-warning" style="color: white;">{{ $revisionRequest->status }}</span></td>
                                        @elseif($revisionRequest->status == 'Done')
                                        <td><span class="label label-default" style="color: white;">{{ $revisionRequest->status }}</span></td>
                                        @else
                                        <td><span class="label label-danger" style="color: white;">{{ $revisionRequest->status }}</span></td>
                                        @endif
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
                    <div class="col-md-4">

                        <div class="x-block">
                            <div class="x-block-head">
                                <h3>TO DO LIST</h3>
                                <div class="pull-right">
                                    <button class="btn btn-default">ACTIONS <span class="fa fa-angle-down" style="margin-left: 20px;"></span></button>
                                </div>
                            </div>
                            <div class="x-block-content x-todo">
                                <div class="x-todo-header">
                                    <label class="check"><input type="checkbox" class="icheckbox"></label>
                                    <h3>7 NEW TASKS FOR TODAY</h3>
                                    <button class="btn btn-default pull-right">TODAY: 14 SEP. 2015 <span class="fa fa-angle-down"></span></button>
                                </div>
                                <div class="x-todo-content scroll" style="height: 550px;">
                                    <div class="item">
                                        <div class="head">
                                            <div class="pull-left"><span class="status status-high"></span> Priority: High</div>
                                            <div class="pull-left">Project: ATLANT Template</div>
                                            <div class="pull-right"><span class="fa fa-clock-o"></span> added few minutes ago</div>
                                        </div>
                                        <div class="title">
                                            <label class="check"><input type="checkbox" class="icheckbox"></label>
                                            <h4>MAKE NEW ATLANT DASHBOARD</h4>
                                        </div>
                                        <div class="content">
                                            Donec porta suscipit odio et luctus. Mauris vel velit dignissim, lobortis mauris non, ultricies sapien
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="head">
                                            <div class="pull-left"><span class="status status-low"></span> Priority: Low</div>
                                            <div class="pull-left">Project: New awesome projec</div>
                                            <div class="pull-right"><span class="fa fa-clock-o"></span> added 15 minutes ago</div>
                                        </div>
                                        <div class="title">
                                            <label class="check"><input type="checkbox" class="icheckbox"></label>
                                            <h4>CALL MARTIN PHILLIPS ABOUT NEW PROJECT </h4>
                                        </div>
                                        <div class="content">
                                            Fusce eu nunc nisl. Duis tincidunt dui lectus. Suspendisse urna dolor, venenatis eu bibendum ut, placerat id sem. Nulla iaculis augue in nulla rutrum
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="head">
                                            <div class="pull-left"><span class="status status-low"></span> Priority: Low</div>
                                            <div class="pull-left">Project: Imaginary Shop</div>
                                            <div class="pull-right"><span class="fa fa-clock-o"></span> added 3 hours ago</div>
                                        </div>
                                        <div class="title">
                                            <label class="check"><input type="checkbox" class="icheckbox"></label>
                                            <h4>PRINT THE INOVOISES FOR BRIAN DAWSON</h4>
                                        </div>
                                        <div class="content">
                                            Donec porta suscipit odio et luctus. Mauris vel velit dignissim, lobortis mauris non, ultricies sapien
                                        </div>
                                    </div>
                                </div>
                                <div class="x-todo-footer">
                                    <div class="pull-right">
                                        <a href="#"><span class="fa fa-plus"></span> Add new task</a>
                                    </div>
                                </div>
                            </div>
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
                { y: '{{ $data->day }}', a: {{ $data->revision_request }} ,b: {{ $data->revision_request + 1 }}},
                @endforeach
              ],
              xkey: 'y',
              ykeys: ['a','b'],
              labels: ['Revision Request','CPAR'],
              resize: true,
              pointSize: '8px',
              //pointStrokeColors: '#DEE4EC',
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
