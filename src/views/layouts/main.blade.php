<!DOCTYPE html>
<html>
    <head>
        @include('maintenance::layouts.main.head')
    </head>
    <body class="skin-blue">

    <header class="header">
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
                    
                    <li id="loading" class="hidden"><img width="40" src="{{ asset('packages/stevebauman/maintenance/img/loading.gif') }}" /></li>
                    
                    @include('maintenance::layouts.main.notifications')
                    
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="glyphicon glyphicon-user"></i>
                            <span>{{ Sentry::getUser()->first_name }} {{ Sentry::getUser()->last_name }} <i class="caret"></i></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header bg-light-blue">
                                <img src="{{ asset('packages/stevebauman/maintenance/adminlte/img/user.jpg') }}" class="img-circle" alt="User Image" />
                                <p>
                                    {{ Sentry::getUser()->first_name }} {{ Sentry::getUser()->last_name }}
                                    <small>Member since {{ Sentry::getUser()->created_at->format('M. Y') }}</small>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <li class="user-body"></li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ route('maintenance.logout') }}" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
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
                        <img src="{{asset('packages/stevebauman/maintenance/adminlte/img/user.jpg')}}" class="img-circle" alt="User Image" />
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
                    
                    @if(Sentry::hasAccess('maintenance.dashboard.index'))
                    <li class="{{ (Route::currentRouteName() == 'maintenance.dashboard.index' ? 'active' : NULL) }} treeview">
                        <a href="{{ route('maintenance.dashboard.index') }}">
                            <i class="fa fa-dashboard"></i> Dashboard
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="{{ route('maintenance.dashboard.index') }}" style="margin-left: 10px;">
                                    <i class="fa fa-dashboard"></i> Dashboard
                                </a>
                            </li>

                            <li>
                                <a href="#" style="margin-left: 10px;">
                                    <i class="fa fa-calendar"></i> Calendar
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('maintenance.work-orders.assigned.index') }}" style="margin-left: 10px;">
                                    <i class="fa fa-book"></i> Assigned Work Orders
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    
                    @if(Sentry::hasAccess('maintenance.work-orders.index'))
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-wrench"></i> Maintenance
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            @if(Sentry::hasAccess('maintenance.work-orders.index'))
                            <li>
                                <a href="{{ route('maintenance.work-orders.index') }}" style="margin-left: 10px;">
                                    <i class="fa fa-book"></i> Work Orders
                                </a>
                            </li>
                            @endif
                            
                            <li>
                                <a href="#" style="margin-left: 10px;">
                                    <i class="fa fa-refresh"></i> Scheduled Maintenance
                                </a>
                            </li>
                            
                            @if(Sentry::hasAccess('maintenance.work-orders.statuses.index'))
                            <li>
                                <a href="{{ route('maintenance.work-orders.statuses.index') }}" style="margin-left: 10px;">
                                    <i class="fa fa-info"></i> Statuses
                                </a>
                            </li>
                            @endif
                            
                            @if(Sentry::hasAccess('maintenance.work-orders.priorities.index'))
                            <li>
                                <a href="{{ route('maintenance.work-orders.priorities.index') }}" style="margin-left: 10px;">
                                    <i class="fa fa-exclamation-circle"></i> Priorities
                                </a>
                            </li>
                            @endif
                            
                            @if(Sentry::hasAccess('maintenance.work-orders.categories.index'))
                            <li>
                                <a href="{{ route('maintenance.work-orders.categories.index') }}" style="margin-left: 10px;">
                                    <i class="fa fa-folder"></i> Categories
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    
                    @if(Sentry::hasAccess('maintenance.inventory.index'))
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-dropbox"></i> Inventory
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            @if(Sentry::hasAccess('maintenance.inventory.index'))
                            <li>
                                <a href="{{ route('maintenance.inventory.index') }}" style="margin-left: 10px;">
                                            <i class="fa fa-gears"></i> All Items
                                </a>
                            </li>
                            @endif
                            
                            @if(Sentry::hasAccess('maintenance.inventory.categories.index'))
                            <li>
                                <a href="{{ route('maintenance.inventory.categories.index') }}" style="margin-left: 10px;">
                                    <i class="fa fa-folder"></i> Categories
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    
                    @if(Sentry::hasAccess('maintenance.assets.index'))
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-truck"></i> Assets
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="{{ route('maintenance.assets.index') }}" style="margin-left: 10px;">
                                    <i class="fa fa-book"></i> All Assets
                                </a>
                            </li>
                            @if(Sentry::hasAccess('maintenance.assets.categories.index'))
                            <li>
                                <a href="{{ route('maintenance.assets.categories.index') }}" style="margin-left: 10px;">
                                    <i class="fa fa-folder"></i> Categories
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    
                    @if(Sentry::hasAccess('maintenance.locations.index'))
                    <li>
                        <a href="{{ route('maintenance.locations.index') }}">
                            <i class="fa fa-location-arrow"></i> Locations
                        </a>
                    </li>
                    @endif
                    
                    @if(!Sentry::hasAccess('maintenance.dashboard.index'))
                    <li>
                        <a href="{{ route('maintenance.work-requests.index') }}">
                            <i class="fa fa-book"></i>
                            My Work Requests
                        </a>
                    </li>
                    @endif
                    
                    @if(Sentry::hasAccess('maintenance.metrics.index'))
                    <li>
                        <a href="{{ route('maintenance.metrics.index') }}">
                            <i class="fa fa-anchor"></i> 
                            Metrics
                        </a>
                    </li>
                    @endif
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
                    @include('maintenance::layouts.main.alert')
                </div>
                
                <div id="content">
                    @yield('content')
                </div>
            </section>
        </aside><!-- /.right-side -->
    </div><!-- ./wrapper -->
    
    @include('maintenance::layouts.main.foot')
    
    <!-- Bootbox-->
    {{ HTML::script('packages/stevebauman/maintenance/adminlte/bootbox/bootbox.min.js') }}
    <!-- AdminLTE App -->
    {{ HTML::script('packages/stevebauman/maintenance/adminlte/js/app.js') }}

    </body>
</html>