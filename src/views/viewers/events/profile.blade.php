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
    
    <dt>Starts:</dt>
    <dd>{{ $event->start }}</dd>
    
    <p></p>
    
    <dt>Ends:</dt>
    <dd>{{ $event->end }}</dd>
    
</dl>