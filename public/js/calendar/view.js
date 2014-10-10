
$(document).ready(function(){

    var calendar = $('#calendar');

    var url = calendar.data('event-url');

    var dateFormat = 'MMMM dS, yyyy';
    var timeFormat = 'h:mmtt';

    calendar.fullCalendar({
        header: {
             left: 'prev,next today',
             center: 'title',
             right: 'agendaWeek,agendaDay'
         },
         defaultView: 'agendaWeek',
         buttonText: {
             prev: "<span class='fa fa-caret-left'></span>",
             next: "<span class='fa fa-caret-right'></span>",
             today: 'today',
             week: 'week',
             day: 'day'
         },
         events: {
             url: url,
             type: 'GET',
             error: function() {
                 alert('Error retrieving events');
             }
         },
         eventClick: function(calEvent, jsEvent, view) {

             $.ajax({
                 url: "/api/calendar/events/"+calEvent.id
             })
             .done(function( data ) {
                 bootbox.dialog({
                     message: data,
                     title: calEvent.title,
                     buttons: {
                         main: {
                             label: "Close",
                             className: "btn-default"
                         },
                         success: {
                             label: "View Details",
                             className: "btn-primary"
                         }
                     }
                 });
             });

         }
     });


});