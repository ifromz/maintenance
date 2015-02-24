<meta charset="UTF-8">
<title>{{ strip_tags($siteTitle) }} | {{ $title }}</title>
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

<!-- jQuery -->
{{ HTML::script('packages/stevebauman/maintenance/resources/jquery/dist/jquery.js') }}

<!-- jQuery UI -->
{{ HTML::script('packages/stevebauman/maintenance/resources/jquery-ui/jquery-ui.min.js') }}

<!-- Moment JS -->
{{ HTML::script('packages/stevebauman/maintenance/resources/moment/moment.js') }}

<!-- FullCalendar -->
{{ HTML::script('packages/stevebauman/maintenance/resources/fullcalendar/dist/fullcalendar.min.js') }}

<!-- Styles -->
<!-- Bootstrap 3.1.0 -->
{{ HTML::style('packages/stevebauman/maintenance/resources/AdminLTE/bootstrap/css/bootstrap.min.css') }}

<!-- Bootstrap stackable modals extension -->
{{ HTML::style('packages/stevebauman/maintenance/resources/bootstrap-modal/css/bootstrap-modal.css') }}

<!-- Select2 3.4.5-->
{{ HTML::style('packages/stevebauman/maintenance/resources/select2/select2.css') }}
{{ HTML::style('packages/stevebauman/maintenance/resources/select2/select2-bootstrap.css') }}

<!-- Theme style -->
{{ HTML::style('packages/stevebauman/maintenance/resources/AdminLTE/dist/css/AdminLTE.min.css') }}
{{ HTML::style('packages/stevebauman/maintenance/resources/AdminLTE/dist/css/skins/_all-skins.min.css') }}

<!-- Custom style -->
{{ HTML::style('packages/stevebauman/maintenance/css/custom.css') }}

<!-- JS Tree Style -->
{{ HTML::style('packages/stevebauman/maintenance/resources/jstree/dist/themes/default/style.min.css') }}

<!-- FullCalendar -->
{{ HTML::style('packages/stevebauman/maintenance/resources/fullcalendar/dist/fullcalendar.css') }}
{{ HTML::style('packages/stevebauman/maintenance/resources/fullcalendar/dist/fullcalendar.print.css', array('media'=>'print')) }}

<!-- Mobiscroll Date/Time Picker -->
{{ HTML::style('packages/stevebauman/maintenance/resources/mobiscroll/css/mobiscroll.animation.css') }}
{{ HTML::style('packages/stevebauman/maintenance/resources/mobiscroll/css/mobiscroll.icons.css') }}

{{ HTML::style('packages/stevebauman/maintenance/resources/mobiscroll/css/mobiscroll.widget.css') }}
{{ HTML::style('packages/stevebauman/maintenance/resources/mobiscroll/css/mobiscroll.widget.ios-classic.css') }}
{{ HTML::style('packages/stevebauman/maintenance/resources/mobiscroll/css/mobiscroll.widget.ios.css') }}

{{ HTML::style('packages/stevebauman/maintenance/resources/mobiscroll/css/mobiscroll.scroller.css') }}
{{ HTML::style('packages/stevebauman/maintenance/resources/mobiscroll/css/mobiscroll.scroller.ios-classic.css') }}
{{ HTML::style('packages/stevebauman/maintenance/resources/mobiscroll/css/mobiscroll.scroller.ios.css') }}

<!-- End Styles -->