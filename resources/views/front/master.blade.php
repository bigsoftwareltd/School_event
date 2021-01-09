@include('front.topbar')
@include('front.footer')
@include('front.header-resource')
@include('front.script-resource')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@yield('title')</title>
    @yield('header-resource')

</head>
<body class="site-layout-fluid">
<div id="main_page" class="ali_azom site">

{{--    <a class="skip-link screen-reader-text" href="#content">Skip to content</a>--}}
@yield('topbar')
@yield('content')
</div>
@yield('footer')
@yield('script-resource')

</body>

</html>
