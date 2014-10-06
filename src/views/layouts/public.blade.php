<!DOCTYPE html>
<html class="bg-black">
<head>
    <meta charset="UTF-8">
    <title>{{ $site_title }} | {{ $title }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- bootstrap 3.1.0 -->
    {{ HTML::style('packages/stevebauman/maintenance/adminlte/css/bootstrap.min.css') }}
    <!-- font Awesome -->
    {{ HTML::style('packages/stevebauman/maintenance/adminlte/css/font-awesome.min.css') }}
    <!-- Theme style -->
    {{ HTML::style('packages/stevebauman/maintenance/adminlte/css/adminlte.css') }}
    
    <!-- jQuery 1.10.2 -->
    {{ HTML::script('packages/stevebauman/maintenance/adminlte/js/jquery-1.10.2.js') }}
    <!-- Bootstrap -->
    {{ HTML::script('packages/stevebauman/maintenance/adminlte/js/bootstrap.min.js') }}
    
    {{ HTML::script('packages/stevebauman/maintenance/ckeditor/ckeditor.js') }}
    
    {{ HTML::script('packages/stevebauman/maintenance/js/base.js') }}
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body class="bg-black">
    
    @yield('content')

</body>
</html>