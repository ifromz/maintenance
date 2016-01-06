<!DOCTYPE html>

<html>

    <head>

    @include('layouts.partials.head')

    @yield('styles')

    @yield('head')

    </head>

    <body class="skin-blue fixed">

    @include('layouts.partials.flash')

        <div class="wrapper">

            <header class="main-header">

                @yield('nav.head')

                <a href="{{ route('maintenance.dashboard.index') }}" class="logo">{{ memorize('site.name', 'Maintenance') }}</a>

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

                            @include('layouts.partials.notifications')

                            @include('layouts.partials.profile')

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
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">

                    <div class="row">
                        <div class="col-md-12">
                            <!-- Breadcrumbs -->
                            @section('breadcrumb')
                                {!! Breadcrumbs::renderIfExists() !!}
                            @show
                        </div>
                    </div>

                </section>

                <!-- Main content -->
                <section class="content">
                    <div id="content" class="col-md-12">
                        @yield('content')
                    </div>
                </section>

                <div class="clearfix"></div>
                <!-- End Main Content -->
            </div>
            <!-- /.right-side -->
        </div>
        <!-- ./wrapper -->

        @include('layouts.partials.foot')

        @yield('foot')

        @yield('scripts')

    </body>

</html>
