<legend>Upcoming Recurrences</legend>

@if(count($recurrences) > 0)

    {{
        $recurrences->columns(array(
                'start' => 'Start',
                'end' => 'End',
                'action' => 'Action'
            ))
            ->modify('start', function($event){
                return $event->viewer()->startFormatted;
            })
            ->modify('end', function($event){
                return $event->viewer()->endFormatted;
            })
            ->modify('action', function($event) {
                return $event->viewer()->btnActions;
            })
            ->render()
    }}
    
@else
<h5>There are no upcoming recurrences to list.</h5>
@endif