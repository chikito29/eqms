<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- META SECTION -->
        <title>Pending | eQMS</title>
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
            <div class="error-text">Request Sent</div>
            <div class="error-subtext">Your request for temporary access is subject for Approval. You will receive an email regarding your request.</div>
            <div class="error-actions">
                <div class="row">
                    <div class="col-md-6">
                        <button class="btn btn-info btn-block btn-lg" onClick="document.location.href = '{{ url('/home') }}';">Back to home</button>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-primary btn-block btn-lg" onClick="history.back();">Previous page</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
