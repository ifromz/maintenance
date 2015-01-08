<!DOCTYPE html>
<html>
<head>

    @include('maintenance::layouts.partials.head')

    @yield('head')

</head>
<body class="skin-blue">

<header class="header">

    @yield('nav.head')

    <a href="{{ route('maintenance.dashboard.index') }}" class="logo"><i class="fa fa-wrench"></i> {{ $siteTitle }}</a>

    <nav class="navbar navbar-static-top" role="navigation">

        <!-- Sidebar toggle button-->
        <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-right">
            <ul class="nav navbar-nav">

                @include('maintenance::layouts.partials.notifications')

                @include('maintenance::layouts.partials.profile')

            </ul>
        </div>
    </nav>
</header>
<!--End of header-->

<div class="wrapper row-offcanvas row-offcanvas-left">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side sidebar-offcanvas">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ asset('packages/stevebauman/maintenance/img/user.jpg') }}" class="img-circle"
                         alt="User Image"/>
                </div>
                <div class="pull-left info">
                    <p>Hello,
                        @if(Sentry::getUser()->first_name)
                            {{ Sentry::getUser()->first_name }}
                        @else
                            {{ Sentry::getUser()->last_name }}
                        @endif
                    </p>
                </div>
            </div>

            <ul class="sidebar-menu">
                @yield('nav.left')
            </ul>

        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Right side column. Contains the navbar and content of the page -->
    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            @yield('header')
            <ol class="breadcrumb">
                @section('breadcrumb')
                    <li><a href="{{ route('maintenance.dashboard.index') }} ">
                            <i class="fa fa-dashboard"></i>
                            Dashboard
                        </a>
                    </li>
                @show
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div id="alerts">
                @include('maintenance::layouts.partials.alert')
            </div>

            <div id="content">
                @yield('content')
            </div>
        </section>
    </aside>
    <!-- /.right-side -->
</div>
<!-- ./wrapper -->

@include('maintenance::layouts.partials.foot')

@yield('foot')

</body>
</html>