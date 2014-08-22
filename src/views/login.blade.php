<!DOCTYPE html>
<html class="bg-black">
<head>
    <meta charset="UTF-8">
    <title>{{ $site_title }} | Log in</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- bootstrap 3.1.0 -->
    {{ HTML::style('packages/stevebauman/maintenance/adminlte/css/bootstrap.min.css') }}
    <!-- font Awesome -->
    {{ HTML::style('packages/stevebauman/maintenance/adminlte/css/font-awesome.min.css') }}
    <!-- Theme style -->
    {{ HTML::style('packages/stevebauman/maintenance/adminlte/css/adminlte.css') }}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body class="bg-black">

<div class="form-box" id="login-box">
    <div class="header bg-light-blue">Sign In</div>
    <form id="maintenance-login" action="{{ route('maintenance.login') }}" method="post">
        <div class="body bg-gray">
            @if (Session::has('message'))
            <div class="status-message alert alert-{{ Session::get('messageType') }}">
                {{ Session::get('message') }}
            </div>
            @endif
            
            <div id="maintenance-login-status">
            
            </div>
            
            <div class="form-group">
                <input type="text" name="username" class="form-control" placeholder="Username"/>
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password"/>
            </div>
            <div class="form-group">
                <input type="checkbox" name="remember" value="true"/> Remember me
            </div>
        </div>
        <div class="footer">
            <button type="submit" class="btn bg-light-blue btn-block">Sign in</button>
        </div>
    </form>
</div>

<!-- jQuery 1.10.2 -->
{{ HTML::script('packages/stevebauman/maintenance/adminlte/js/jquery-1.10.2.js') }}
<!-- Bootstrap -->
{{ HTML::script('packages/stevebauman/maintenance/adminlte/js/bootstrap.min.js') }}

{{ HTML::script('packages/stevebauman/maintenance/js/base.js') }}
{{ HTML::script('packages/stevebauman/maintenance/js/auth/login.js') }}
</body>
</html>