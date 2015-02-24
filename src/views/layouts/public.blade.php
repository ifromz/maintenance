<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        @include('maintenance::layouts.partials.head', array(
            'siteTitle' => $siteTitle,
            'title' => $title,
        ))
    </head>
    <body class="login-page">

    @yield('content')

    @include('maintenance::layouts.partials.foot')

    </body>
</html>