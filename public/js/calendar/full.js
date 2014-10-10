
$(document).ready(function(){

    var calendar = $('#calendar');

    var url = calendar.data('event-url');

    var dateFormat = 'MMMM dS, yyyy';
    var timeFormat = 'h:mmtt';

    calendar.fullCalendar({
        header: {
             left: 'prev,next today',
             center: 'title',
             right: 'month,agendaWeek,agendaDay'
         },
         buttonText: {
             prev: "<span class='fa fa-caret-left'></span>",
             next: "<span class='fa fa-caret-right'></span>",
             today: 'today',
             month: 'month',
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
         editable: true,
         eventDrop: function(event, dayDelta, minuteDelta, allDay, revertFunc) {

             var format = '';

             if(allDay){
                 format = dateFormat;
             } else {
                 format = dateFormat+" - "+timeFormat;
             }

             bootbox.confirm({
                 title: "Are you sure you want to move this event?",
                 message: event.title+" will be moved to "+$.fullCalendar.formatDate(event.start, format),
                 callback: function(result){
                    if(result){
                        updateEvent(calendar, event);
                    } else{
                        revert();
                    }
                 }
             });

             function revert(){
                 revertFunc();
             }
         },
         eventResize: function(event, dayDelta, minuteDelta, revertFunc, jsEvent, ui, view){

             bootbox.confirm({
                 title: "Are you sure you want to change the time of this event?",
                 message: event.title+" will now end at "+$.fullCalendar.formatDate(event.end, dateFormat+" - "+timeFormat),
                 callback: function(result){
                    if(result){
                        updateEvent(calendar, event);
                    } else{
                        revert();
                    }
                 }
             });

             function revert(){
                 revertFunc();
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