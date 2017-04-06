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
            <div class="error-text">REQUEST SENT</div>
            <div class="error-subtext">Your request for Access has been sent. Wait for approval of your request.</div>
            <div class="error-actions">
                <div class="row">
                    <div class="col-md-6">
                        <button class="btn btn-info btn-block btn-lg" onClick="document.location.href = 'index.html';">Back to dashboard</button>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-primary btn-block btn-lg" onClick="">Previous page</button>
                    </div>
                </div>
            </div>
            <div class="error-subtext">Please note that your access to eQMS will be of a limitted time only.</div>
        </div>
    </body>
</html>
