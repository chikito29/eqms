<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- META SECTION -->
        <title>@yield('page-title')</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <link rel="icon" href="{{ url('favicon.ico') }}" type="image/x-icon" />
        <!-- END META SECTION -->

        <!-- CSS INCLUDE -->
        <link rel="stylesheet" type="text/css" id="theme" href="{{ url('css/theme-default.css') }}"/>
        <!-- EOF CSS INCLUDE -->
    </head>
    <body class="x-dashboard">
        <!-- START PAGE CONTAINER -->
        <div class="page-container">
            <!-- PAGE CONTENT -->
            <div class="page-content">
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">

                    <div class="x-hnavigation" style="margin-bottom: 30px;">
                        <div class="x-hnavigation-logo">
                            <a href="{{ url('/') }}">eQMS</a>
                        </div>
                        <ul>
                            <li class="@yield('nav-home')">
                                <a href="{{ route('pages.home') }}">Home</a>
                            </li>
                            <li class="xn-openable @yield('nav-document')">
                                <a href="#">Documents</a>
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
                            <li class="xn-openable">
                                <a href="#">View</a>
                                <ul>
                                    <li><a href="#"><span class="fa fa-folder"></span> Revision Logs</a></li>
                                </ul>
                            </li>
                            <li class="xn-openable @yield('nav-actions')">
                                <a href="#">Actions</a>
                                <ul>
                                    <li><a href="{{ route('documents.create') }}"><span class="fa fa-file-o"></span> New Document</a></li>
                                    <li><a href="{{ route('revision-requests.index') }}"><span class="fa fa-pencil"></span> Revision Request</a></li>
                                    <li><a href="{{ route('sections.index') }}"><span class="fa fa-folder-o"></span> Manage Sections</a></li>
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
                                        <li><a href="pages-lock-screen.html"><span class="fa fa-lock"></span> Lock Screen</a></li>
                                        <li><a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span> Sign Out</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    @yield('page-content')

                    <div class="footer x-content-footer">
                        Copyright © 2017 NEWSIM. All rights reserved
                    </div>

                </div>
                <!-- END PAGE CONTENT WRAPPER -->
            </div>
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->

        @yield('message-box')

        <!-- MESSAGE BOX-->
        <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                    <div class="mb-content">
                        <p>Are you sure you want to log out?</p>
                        <p>Press No if youwant to continue work. Press Yes to logout current user.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="pages-login.html" class="btn btn-success btn-lg">Yes</a>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MESSAGE BOX-->

        @yield('modals')

        <!-- START PRELOADS -->
        <audio id="audio-alert" src="{{ url('audio/alert.mp3') }}" preload="auto"></audio>
        <audio id="audio-fail" src="{{ url('audio/fail.mp3') }}" preload="auto"></audio>
        <!-- END PRELOADS -->

    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        <script type="text/javascript" src="{{ url('js/plugins/jquery/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ url('js/plugins/jquery/jquery-ui.min.js') }}"></script>
        <script type="text/javascript" src="{{ url('js/plugins/bootstrap/bootstrap.min.js') }}"></script>
        <!-- END PLUGINS -->

        <!-- START THIS PAGE PLUGINS-->
        <script type="text/javascript" src="{{ url('js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js') }}"></script>
        <script type="text/javascript" src="{{ url('js/plugins/scrolltotop/scrolltopcontrol.js') }}"></script>
        <script type='text/javascript' src="{{ url('js/plugins/noty/jquery.noty.js') }}"></script>
        <script type='text/javascript' src="{{ url('js/plugins/noty/layouts/topRight.js') }}"></script>
        <script type='text/javascript' src="{{ url('js/plugins/noty/themes/default.js') }}"></script>
        @yield('scripts')
        <script type="text/javascript">
            $(function(){
                @if($notify = session('notify'))
                    noty({text: '{{ $notify['message'] }}', layout: 'topRight', type: '{{ $notify['type'] }}'});
                @endif
            });
        </script>
        <!-- END THIS PAGE PLUGINS-->

        <!-- START TEMPLATE -->
        <script type="text/javascript" src="{{ url('js/plugins.js') }}"></script>
        <script type="text/javascript" src="{{ url('js/actions.js') }}"></script>
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->
    </body>
</html>
