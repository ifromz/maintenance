
<dl class="dl-horizontal">
    
    <dt>Title</dt>
    <dd>{{ $event->title }}</dd>
    
    <p></p>
    
    @if($event->user)
    <dt>Created By</dt>
    <dd>{{ $event->user->full_name }}</dd>
    
    <p></p>
    @endif
    
    <dt>Created At</dt>
    <dd>{{ $event->created_at }}</dd>
    
    <p></p>
    
    <dt>Starts At</dt>
    <dd>{{ $event->start_formatted }}</dd>
    
    <p></p>
    
    <dt>Ends At</dt>
    <dd>{{ $event->end_formatted }}</dd>
    
    <p></p>
    
    <dt>All Day</dt>
    <dd>{{ $event->allDay_label }}</dd>
    
    <p></p>
    
    
    @if($event->isRecurring())
    <dt>Recurring Frequency</dt>
    <dd>{{ $event->recur_frequency }}</dd>
    
    <p></p>
    
    <dt>Recurring Limit</dt>
    <dd>
        @if($event->recur_count)
            {{ $event->recur_count }}
        @else
            <em>No Limit</em>
        @endif
    </dd>
    
    <p></p>
    
    <dt>Recurring Frequency</dt>
    <dd>{{ $event->recur_frequency }}</dd>
    
    @endif
    
</dl>