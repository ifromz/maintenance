<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $siteTitle }} | {{ $title }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    
    <!-- Styles -->
        <!-- bootstrap 3.1.0 -->
        {{ HTML::style('packages/stevebauman/maintenance/adminlte/css/bootstrap.min.css') }}
        
        <!-- bootstrap stackable modals extension -->
        {{ HTML::style('packages/stevebauman/maintenance/bootstrap-modal/css/bootstrap-modal.css') }}
        
        <!-- Font Awesome -->
        {{ HTML::style('packages/stevebauman/maintenance/adminlte/css/font-awesome.min.css') }}
        
        <!-- Ionicons -->
        {{ HTML::style('packages/stevebauman/maintenance/adminlte/css/ionicons.min.css') }}
        
        <!-- Select2 3.4.5-->
        {{ HTML::style('packages/stevebauman/maintenance/adminlte/select2-3.4.5/select2.css') }}
        {{ HTML::style('packages/stevebauman/maintenance/adminlte/select2-3.4.5/select2-bootstrap.css') }}
        
        <!-- Theme style -->
        {{ HTML::style('packages/stevebauman/maintenance/adminlte/css/adminlte.css') }}
        
        <!-- Tags style -->
        {{ HTML::style('packages/stevebauman/maintenance/css/tags.css') }}
        
        <!-- JS Tree Style -->
        {{ HTML::style('packages/stevebauman/maintenance/jsTree/dist/themes/default/style.min.css') }}
        
        <!-- Pickadate Styles -->
        {{ HTML::style('packages/stevebauman/maintenance/pickadate.js-3.5.3/lib/themes/classic.css') }}
        {{ HTML::style('packages/stevebauman/maintenance/pickadate.js-3.5.3/lib/themes/classic.date.css') }}
        {{ HTML::style('packages/stevebauman/maintenance/pickadate.js-3.5.3/lib/themes/classic.time.css') }}
        
        <!-- TreeTable -->
        {{ HTML::style('packages/stevebauman/maintenance/ludo-jquery-treetable/css/jquery.treetable.css') }}
        {{ HTML::style('packages/stevebauman/maintenance/ludo-jquery-treetable/css/jquery.treetable.theme.default.css') }}
        
        <!-- FullCalendar -->
        {{ HTML::style('packages/stevebauman/maintenance/fullcalendar/fullcalendar.css') }}
        {{ HTML::style('packages/stevebauman/maintenance/fullcalendar/fullcalendar.print.css', array('media'=>'print')) }}

    <!-- End Styles -->
    
    <!-- Scripts -->
        <!-- jQuery 1.10.2 -->
        {{ HTML::script('packages/stevebauman/maintenance/adminlte/js/jquery-1.11.1.min.js') }}
        
        <!-- jQuery UI 1.10.3 -->
        {{ HTML::script('packages/stevebauman/maintenance/js/vendor/jquery-ui-1.10.3.min.js') }}
        
        <!-- Bootstrap -->
        {{ HTML::script('packages/stevebauman/maintenance/adminlte/js/bootstrap.min.js') }}
        
        <!-- bootstrap modals -->
        {{ HTML::script('packages/stevebauman/maintenance/bootstrap-modal/js/bootstrap-modalmanager.js') }}
        {{ HTML::script('packages/stevebauman/maintenance/bootstrap-modal/js/bootstrap-modal.js') }}
        
        <!-- Select2 3.4.5-->
        {{ HTML::script('packages/stevebauman/maintenance/adminlte/select2-3.4.5/select2.min.js') }}
        
        <!-- JS Tree -->
        {{ HTML::script('packages/stevebauman/maintenance/jsTree/dist/jstree.min.js') }}
        
        <!-- Pickadate -->
        
        {{ HTML::script('packages/stevebauman/maintenance/pickadate.js-3.5.3/lib/picker.js') }}
        {{ HTML::script('packages/stevebauman/maintenance/pickadate.js-3.5.3/lib/picker.date.js') }}
        {{ HTML::script('packages/stevebauman/maintenance/pickadate.js-3.5.3/lib/picker.time.js') }}
        {{ HTML::script('packages/stevebauman/maintenance/pickadate.js-3.5.3/lib/legacy.js') }}
        <!-- Typeahead -->
        {{ HTML::script('packages/stevebauman/maintenance/js/vendor/bootstrap3-typeahead.js') }}
        
        <!-- TreeTable -->
    	{{ HTML::script('packages/stevebauman/maintenance/ludo-jquery-treetable/jquery.treetable.js') }}
        
        <!-- FullCalendar -->
        {{ HTML::script('packages/stevebauman/maintenance/fullcalendar/fullcalendar.js') }}
        
        {{ HTML::script('packages/stevebauman/maintenance/ckeditor/ckeditor.js') }}
        
        {{ HTML::script('packages/stevebauman/maintenance/jscroll-master/jquery.jscroll.min.js') }}
        
        {{ HTML::script('packages/stevebauman/maintenance/js/base.js') }}
  	<!-- End Scripts -->
    
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        
    <!-- End Scripts -->
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
                
                @include('maintenance::layouts.main.notifications')
                
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-user"></i>
                        <span>{{ Sentry::getUser()->first_name }} {{ Sentry::getUser()->last_name }} <i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header bg-light-blue">
                            <img src="{{asset('packages/stevebauman/maintenance/adminlte/img/user.jpg')}}" class="img-circle" alt="User Image" />
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
                                <a href="{{route('maintenance.logout')}}" class="btn btn-default btn-flat">Sign out</a>
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

            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
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
                            <a href="#" style="margin-left: 10px;">
                                <i class="fa fa-book"></i> Assigned Work Orders
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-wrench"></i> Maintenance
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="{{ route('maintenance.work-orders.index') }}" style="margin-left: 10px;">
                                <i class="fa fa-book"></i> Work Orders
                            </a>
                        </li>
                        
                        <li>
                            <a href="#" style="margin-left: 10px;">
                                <i class="fa fa-refresh"></i> Scheduled Maintenance
                            </a>
                        </li>
                        
                        <li>
                            <a href="{{ route('maintenance.work-orders.categories.index') }}" style="margin-left: 10px;">
                                <i class="fa fa-folder"></i> Categories
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-dropbox"></i> Inventory
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="{{ route('maintenance.inventory.index') }}" style="margin-left: 10px;">
                        		<i class="fa fa-gears"></i> All Items
                            </a>
                        </li>
                        
                        @if($siteCategoryRoots)
                        
                            @foreach($siteCategoryRoots as $category)
                            
                            <li>
                                <a href="{{ route('maintenance.inventory.index', array('category_id'=>$category->id)) }}" style="margin-left: 10px;">
                                    {{ $category->name }}
                                </a>
                            </li>
                            
                            @endforeach
                        
                        @endif
                    </ul>
                </li>
                
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
                        
                        @if($siteCategoryRoots)
                        
                            @foreach($siteCategoryRoots as $category)
                            
                            <li>
                                <a href="{{ route('maintenance.assets.index', array('category_id'=>$category->id)) }}" style="margin-left: 10px;">
                                    {{ $category->name }}
                                </a>
                            </li>
                            
                            @endforeach
                        
                        @endif
                        
                    </ul>
                </li>
                
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
            @include('maintenance::partials.alert')
            @yield('content')
        </section>
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<!-- Bootbox-->
{{ HTML::script('packages/stevebauman/maintenance/adminlte/bootbox/bootbox.min.js') }}
<!-- AdminLTE App -->
{{ HTML::script('packages/stevebauman/maintenance/adminlte/js/app.js') }}

</body>
</html>