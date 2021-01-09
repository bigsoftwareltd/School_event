@include('common.topbar.topbar')
@include('common.sidebar.side')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="_base_url" content="{{ url('/') }}">
    <link href="{{asset('/admin/images/school.png')}}" rel="icon">
    <title>@yield('title')</title>
    <link href="{{asset('/admin/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('/admin/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('/admin/css/admin.min.css')}}" rel="stylesheet">
{{--    <link href="{{asset('front/css/animate.css')}}" rel="stylesheet">--}}
    @yield('header-resource')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>


<body id="page-top">
<div id="wrapper">
    @yield('sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @yield('topbar')
            @yield('breadcrumb')
            <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabelLogout"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to logout?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                            <a class="btn btn-primary"href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Container Fluid-->
        @yield('content')
        <!---Container Fluid-->
        </div>
        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
            <span>copyright &copy; <script> document.write(new Date().getFullYear()); </script> - developed by
              <b><a href="https://bigsoftwareltd.com" target="_blank">Big Software Limited</a></b>
            </span>
                </div>
            </div>
        </footer>
        <!-- Footer -->
    </div>
</div>

<!-- Scroll to top -->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<script src="{{asset('/admin/jquery/jquery.min.js')}}"></script>
<script src="{{asset('/admin/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('/admin/jquery-knob/jquery.knob.min.js')}}"></script>
<script src="{{asset('/admin/bootstrap/js/bootstrap.min.js')}}"></script>
{{--<script src="{{asset('/admin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>--}}
<script src="{{asset('/admin/js/admin.min.js')}}"></script>
@yield('script-resource')
@yield('script')
<script type="text/javascript">
    setInterval(function() {

        var currentTime = new Date ( );

        var currentHours = currentTime.getHours ( );

        var currentMinutes = currentTime.getMinutes ( );

        var currentSeconds = currentTime.getSeconds ( );

        currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;

        currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;

        var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";

        currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;

        currentHours = ( currentHours == 0 ) ? 12 : currentHours;

        var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;

        document.getElementById("timer").innerHTML = currentTimeString;

    }, 1000);
</script>
</body>

</html>
