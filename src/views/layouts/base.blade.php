<!DOCTYPE html>

<html>

    <head>

    @include('maintenance::layouts.partials.head')

    @yield('head')

    </head>

    <body class="skin-blue fixed">

        <div class="wrapper">

            <header class="main-header">

                @yield('nav.head')

                <a href="{{ route('maintenance.dashboard.index') }}" class="logo">{{ $siteTitle }}</a>

                <nav class="navbar navbar-static-top" role="navigation">

                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>

                    <div class="navbar-custom-menu">

                        <ul class="nav navbar-nav">

                            @include('maintenance::layouts.partials.notifications')

                            @include('maintenance::layouts.partials.profile')

                        </ul>

                    </div>
                </nav>
            </header>
            <!--End of header-->

            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">

                    <ul class="sidebar-menu">
                        @yield('nav.left')
                    </ul>

                </section>
                <!-- /.sidebar -->
            </aside>
            <!-- /.left-side -->

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    @section('header')
                        <h1>{{ $title }}</h1>
                    @show

                    @section('breadcrumb')
                        {{ Breadcrumbs::renderIfExists() }}
                    @show
                </section>

                <!-- Main content -->
                <section class="content body">
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