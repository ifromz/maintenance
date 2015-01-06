@if($events->count() > 0)

    {{
        $events->columns(array(
                'title' => 'Title / Summary',
                'description' => 'Description',
                'reccuring' => 'Is Reccuring',
                'all_day' => 'All Day',
                'start' => 'Start',
                'end' => 'End',
                'actions' => 'Actions',
            ))
            ->modify('reccuring', function($record){
                return $record->viewer()->lblRecurring;
            })
            ->modify('start', function($record) {
                return $record->viewer()->startFormatted;
            })
            ->modify('end', function($record){
                return $record->viewer()->endFormatted;
            })
            ->modify('all_day', function($record) {
                return $record->viewer()->lblAllDay;
            })
            ->modify('actions', function($record) {
                return $record->viewer()->btnActions;
            })
            ->render()
    }}

@else

    <h5>There are no events to display.</h5>

@endif