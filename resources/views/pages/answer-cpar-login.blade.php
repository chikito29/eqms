
<!DOCTYPE html>
<html lang="en" class="body-full-height">
<head>
    <!-- META SECTION -->
    <title>eQms - CPAR | Login</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <!-- END META SECTION -->

    <!-- CSS INCLUDE -->
    <link rel="stylesheet" type="text/css" id="theme" href="/css/theme-default.css"/>
    <!-- EOF CSS INCLUDE -->
</head>
<body>

<div class="login-container login-v2">

    <div class="login-box animated fadeInDown">
        <div class="login-body">
            <div class="login-title"><strong>Welcome</strong> guest!
                <br>Start answering your CPAR by entering
                <br>the code given by your department head.</div>
            <form action="{{ route('answer-cpar-login-post', $cpar->id) }}" class="form-horizontal" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <div class="col-md-12">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span class="fa fa-lock"></span>
                            </div>
                            <input type="password" class="form-control" placeholder="code" name="code"/>
                        </div>
                        @if($errors->first('code')) @component('layouts.error') {{ $errors->first('code') }} @endcomponent @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <button class="btn btn-primary btn-lg btn-block">Login</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="login-footer">
            <div class="pull-left">
                &copy; 2017 Electronic Quality Management System
            </div>
        </div>
    </div>

</div>

</body>
</html>






