<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- META SECTION -->
        <title>Atlant - Responsive Bootstrap Admin Template</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <link rel="icon" href="{{ url('favicon.ico') }}" type="image/x-icon" />
        <!-- END META SECTION -->

        <!-- CSS INCLUDE -->
        <link rel="stylesheet" type="text/css" id="theme" href="{{ url('css/theme-default.css') }}"/>
        <!-- EOF CSS INCLUDE -->
    </head>
    <body>
        <div class="error-container">
            <div class="error-code">403</div>
            <div class="error-text">Forbidden Access</div>
            <div class="error-subtext">Unfortunately you are not allowed to access eQMS. Contact Administrator or use action below.</div>
            <div class="error-actions">
                <div class="row">
                    <div class="col-md-6">
                        <button class="btn btn-info btn-block btn-lg" onClick="document.location.href = '{{ url('/home') }}';">Back to home</button>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-primary btn-block btn-lg" onClick="">Previous page</button>
                    </div>
                </div>
            </div>
            <div class="error-subtext">Or you can request for a temporary access.</div>
            <div class="row">
                <form class="form-horizontal" action="{{ route('access-requests.store') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{ $user['id'] }}">
                    <input type="hidden" name="user_name" value="{{ $user['first_name'] . ' ' . $user['last_name'] }}">
                <div class="col-md-12">
                    <div class="input-group">
                        <input type="text" placeholder="State your purpose" class="form-control" name="purpose"/>
                        <div class="input-group-btn">
                            <button class="btn btn-primary"><span class="glyphicon glyphicon-arrow-right"></span></button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </body>
</html>
