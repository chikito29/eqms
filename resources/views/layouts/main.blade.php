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
        @yield('style')
        <!-- EOF CSS INCLUDE -->
    </head>
    <body class="x-dashboard">
        <!-- START PAGE CONTAINER -->
        <div class="page-container">
            <!-- PAGE CONTENT -->
            <div class="page-content">
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">

                    @if (request('user.role') == 'super-admin')
                        @include('headers.super-admin')
                    @elseif (request('user.role') == 'admin' || request('user.role') == 'document-controller')
                        @include('headers.admin')
                    @else
                        @include('headers.default')
                    @endif

                    @yield('page-content')

                    <div class="footer x-content-footer no-print">
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
                        <p>Press No if you want to continue work. Press Yes to logout.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="{{ env('NA_URL') . '/logout/' . request('user.id') }}" class="btn btn-success btn-lg">Yes</a>
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
                @if($notify = session()->pull('notify'))
                    noty({text: '{{ $notify['message'] }}', layout: 'topRight', type: '{{ $notify['type'] }}'});
                @endif
            });
        </script>
        <!-- END THIS PAGE PLUGINS-->

        <!-- START TEMPLATE -->
        <script type="text/javascript" src="{{ url('js/plugins.js') }}"></script>
        <script type="text/javascript" src="{{ url('js/actions.js') }}"></script>
        <!-- END TEMPLATE -->

		@yield('post-scripts')
    <!-- END SCRIPTS -->
    </body>
</html>
