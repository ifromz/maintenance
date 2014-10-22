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

    <!-- Custom style -->
    {{ HTML::style('packages/stevebauman/maintenance/css/custom.css') }}

    <!-- JS Tree Style -->
    {{ HTML::style('packages/stevebauman/maintenance/jsTree/dist/themes/default/style.min.css') }}

    <!-- Pickadate Styles -->
    {{ HTML::style('packages/stevebauman/maintenance/pickadate.js-3.5.3/lib/themes/default.css') }}
    {{ HTML::style('packages/stevebauman/maintenance/pickadate.js-3.5.3/lib/themes/default.date.css') }}
    {{ HTML::style('packages/stevebauman/maintenance/pickadate.js-3.5.3/lib/themes/default.time.css') }}

    <!-- TreeTable -->
    {{ HTML::style('packages/stevebauman/maintenance/ludo-jquery-treetable/css/jquery.treetable.css') }}
    {{ HTML::style('packages/stevebauman/maintenance/ludo-jquery-treetable/css/jquery.treetable.theme.default.css') }}

    <!-- FullCalendar -->
    {{ HTML::style('packages/stevebauman/maintenance/fullcalendar/fullcalendar.css') }}
    {{ HTML::style('packages/stevebauman/maintenance/fullcalendar/fullcalendar.print.css', array('media'=>'print')) }}
    
    <!-- jQuery 1.10.2 -->
    {{ HTML::script('packages/stevebauman/maintenance/adminlte/js/jquery-1.11.1.min.js') }}
    
    <!-- jQuery UI 1.10.3 -->
    {{ HTML::script('packages/stevebauman/maintenance/js/vendor/jquery-ui-1.10.3.min.js') }}
    
    
<!-- End Styles -->