<dl class="dl-horizontal">
    
    <dt>Title / Summary:</dt>
    <dd>{{ $event->title }}</dd>
    
    <p></p>
    
    @if($event->description)
    <dt>Description:</dt>
    <dd>{{ $event->description }}</dd>
    
    <p></p>
    @endif
    
    @if($event->location)
    <dt>Location:</dt>
    <dd>{{ $event->location }}</dd>
    
    <p></p>
    @endif
    
    <dt>All Day:</dt>
    <dd>{{ $event->viewer()->lblAllDay }}</dd>
    
    <p></p>
    
    <dt>Starts:</dt>
    <dd>{{ $event->viewer()->startFormatted }}</dd>
    
    <p></p>
    
    <dt>Ends:</dt>
    <dd>{{ $event->viewer()->endFormatted }}</dd>
    
    <p></p>
    
    <dt>Recurring:</dt>
    <dd>{{ $event->viewer()->lblRecurring }}</dd>
    
    <p></p>
    
    <dt>Frequency:</dt>
    <dd>{{ $event->viewer()->recurFrequencyFormatted }}</dd>
    
</dl>