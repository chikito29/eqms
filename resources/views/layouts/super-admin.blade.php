<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- META SECTION -->
        <title>@yield('page-title')</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->

        <!-- CSS INCLUDE -->
        <link rel="stylesheet" type="text/css" id="theme" href="/css/theme-default.css"/>
        <!-- EOF CSS INCLUDE -->
    </head>
    <body class="x-dashboard">
        <!-- START PAGE CONTAINER -->
        <div class="page-container">
            <!-- PAGE CONTENT -->
            <div class="page-content">
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">

                    <div class="x-hnavigation">
                        <div class="x-hnavigation-logo">
                            <a href="{{ url('/') }}">eQMS</a>
                        </div>
                        <ul>
                            <li class="active">
                                <a href="#">Home</a>
                            </li>
                            <li class="xn-openable">
                                <a href="#">Documents</a>
                                <ul>
                                    <li class="xn-openable">
                                        <a href="#"><span class="fa fa-cube"></span> Quality Procedures</a>
                                        <ul>
                                            <li><a href="#">QP01: Document and Data</a></li>
                                            <li><a href="#">QP02: Control of Quality Records</a></li>
                                            <li><a href="#">QP03: Internal Quality Audit</a></li>
                                            <li><a href="#">QP04: Control of Non-conformance</a></li>
                                            <li><a href="#">QP05: Corrective and Preventive Action</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#"><span class="fa fa-life-ring"></span> QWI Manual</a></li>
                                    <li><a href="#"><span class="fa fa-recycle"></span> Position Description</a></li>
                                    <li><a href="#"><span class="fa fa-calendar"></span> QM Procedures</a></li>
                                </ul>
                            </li>
                        </ul>

                        <div class="x-features">
                            <div class="x-features-nav-open">
                                <span class="fa fa-bars"></span>
                            </div>
                            <div class="pull-right">
                                <div class="x-features-search">
                                    <input type="text" name="search">
                                    <input type="submit">
                                </div>
                                <div class="x-features-profile">
                                    <img src="img/no-profile-image.png">
                                    <ul class="xn-drop-left animated zoomIn">
                                        <li><a href="pages-lock-screen.html"><span class="fa fa-lock"></span> Lock Screen</a></li>
                                        <li><a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span> Sign Out</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="page-content-wrap" style="margin-top: 50px;">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-body">

                                        <br><br>
                                        <h1 style="text-align: center;">Welcome to eQMS!</h1><br><br>
                                        <div style="text-align: center; padding-left:50px; padding-right:50px; padding-bottom:50px;">
                                            <h4>
                                            This site is currently being developed in an attempt to convert NSCPI's Quality Manuals into electronic format. We are hoping that through this system, we will be able to maintain and enhance the center's documented Quality Policies and Procedures more dynamically.<br><br><br>We are really working hard to create a highly usable system but since this is a work in progress, we wish to apologize in advance for momentary errors that you might encounter. Nevertheless, we will highly appreciate if you can notify us by dropping an email to <span style="font-weight: bold;">info@newsim.ph</span> should you encounter any.
                                        </h4>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="x-content-footer">
                        Copyright © 2017 NEWSIM. All rights reserved
                    </div>
                </div>
                <!-- END PAGE CONTENT WRAPPER -->
            </div>
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->

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

        <!-- START PRELOADS -->
        <audio id="audio-alert" src="audio/alert.mp3" preload="auto"></audio>
        <audio id="audio-fail" src="audio/fail.mp3" preload="auto"></audio>
        <!-- END PRELOADS -->

    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        <script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap.min.js"></script>
        <!-- END PLUGINS -->

        <!-- START THIS PAGE PLUGINS-->
        <script type="text/javascript" src="js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
        <script type="text/javascript" src="js/plugins/scrolltotop/scrolltopcontrol.js"></script>
        @yield('scripts')
        <!-- END THIS PAGE PLUGINS-->

        <!-- START TEMPLATE -->
        <script type="text/javascript" src="js/plugins.js"></script>
        <script type="text/javascript" src="js/actions.js"></script>
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->
    </body>
</html>
