<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{app_config('AppName')}}</title>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,500,700' rel='stylesheet' type='text/css'>
</head>
<body>

<main id="wrapper" class="wrapper">
    <div class="container jumbo-container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="app-logo-inner text-center">
                    <img src="<?php echo asset(app_config('AppLogo')); ?>" alt="logo" class="bar-logo">
                </div>
                <div class="panel panel-30">
                    <div class="panel-body text-center">
                        <h2 class="error-title-404">404</h2>
                            <p>Whoops! Page Not Found, Go To <a href="{{url('/')}}">Home Page</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


</body>
</html>
