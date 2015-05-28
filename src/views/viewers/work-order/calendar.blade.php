{!! HTML::script('stevebauman/maintenance/js/calendar/view.js') !!}

<script>
    //Boostrap Tab Fix
    $(document).ready(function () {
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $('#calendar').fullCalendar('render');
        });
    });
</script>

<div id="calendar" data-event-url="{{ route('maintenance.api.v1.work-orders.events.show', [$workOrder->id]) }}"></div>
