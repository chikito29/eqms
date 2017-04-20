<?php use Carbon\Carbon; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- META SECTION -->
    <title>eQMS | Answer CPAR</title>
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

            <div class="page-content-wrap">

                <div class="row">
                    <div class="col-md-12">

                        @if($cpar->cparClosed->status == 1)
                            <div class="error-container">
                                <div class="error-text">CPAR form closed</div>
                                <div class="error-subtext">The CPAR you are trying to view was already closed.</div>
                                <div class="error-subtext">If you need a copy of the CPAR please contact the QMR for details.</div>
                            </div>
                        @elseif(Carbon::now()->startOfDay()->gt($dueDate->startOfDay()) && $cpar->cparAnswered->status != 1)
                            <div class="error-container">
                                <div class="error-text">CPAR form expired</div>
                                <div class="error-subtext">You have failed to answer your cpar issued {{ $cpar->created_at->toFormattedDateString() }} <br>
                                    to be answered last {{ $dueDate->toFormattedDateString() }}.</div>
                                <div class="error-subtext">Your department head has also been notified regarding this issue.</div>
                            </div>
                        @elseif($cpar->date_confirmed == NULL)
                            <div class="error-container">
                                <div class="error-text">THANK YOU!</div>
                                <div class="error-text">Your CPAR has been sent to your department head for finalization.</div>
                                <div class="error-subtext">You may or may not be asked to revise your answer.</div>
                            </div>
                        @elseif($cpar->date_confirmed <> NULL)
                            <div class="error-container">
                                <div class="error-text">CPAR was already confirmed.</div>
                                <div class="error-subtext">You will receive an email when the CPAR review is finalized.</div>
                            </div>
                        @else
                            <div class="error-container">
                                <div class="error-code">CPAR</div>
                                <div class="error-text">is on review</div>
                                <div class="error-subtext">Your CPAR is currently being reviewed by QMR.</div>
                            </div>
                        @endif

                    </div>
                </div>

            </div>

            <div class="footer x-content-footer" style="position: absolute; bottom: 0px;">
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
                <p>Press No if you want to continue work. Press Yes to logout current user.</p>
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
<!-- END THIS PAGE PLUGINS-->

<!-- START TEMPLATE -->
<script type="text/javascript" src="{{ url('js/plugins.js') }}"></script>
<script type="text/javascript" src="{{ url('js/actions.js') }}"></script>
<!-- END TEMPLATE -->
<!-- END SCRIPTS -->
</body>
</html>
