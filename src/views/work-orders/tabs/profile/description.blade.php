
<dl class="dl-horizontal">

    @if($workOrder->isComplete() && !$workOrder->report)
        <div class="alert alert-warning">
            <b>Heads Up!</b> This work order is closed, but no report has been submitted detailing it's completion. 
            You should probably fill one out by clicking the <b>Complete</b> button above.
        </div>
    @endif
    
    <dt>Status:</dt>
    <dd>{{ $workOrder->status->label }}</dd>

    <p></p>
    
    <dt>Priority:</dt>
    <dd>{{ $workOrder->priority->label }}</dd>

    <p></p>
    
    <dt>Created By:</dt>
    <dd>{{ $workOrder->user->full_name }}</dd>

    <p></p>

    <dt>Subject:</dt>
    <dd>{{ $workOrder->subject }}</dd>

    <p></p>
    
    @if($workOrder->description)
        <dt>Description:</dt>
        <dd>{{ $workOrder->description }}</dd>

        <p></p>
    @endif
    
    @if($workOrder->assets->count() > 0)
        <dt>Assets Involved:</dt>
        <dd>
            @foreach($workOrder->assets as $asset)
                {{ $asset->label }}
            @endforeach
        </dd>

        <p></p>
    @endif
</dl>