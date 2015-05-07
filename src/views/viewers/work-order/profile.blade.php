<dl class="dl-horizontal">

    <dt>ID:</dt>
    <dd>{{ $workOrder->id }}</dd>

    <p></p>

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

    @if($workOrder->category)
        <dt>Category:</dt>
        <dd>{{ $workOrder->category->trail }}</dd>

        <p></p>
    @endif

    @if($workOrder->location)
        <dt>Location:</dt>
        <dd>{{ $workOrder->location->trail }}</dd>

        <p></p>
    @endif

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

    <dt>Started At:</dt>
    <dd>{{ $workOrder->viewer()->lblStartedAt }}</dd>

    <p></p>

    <dt>Completed At:</dt>
    <dd>{{ $workOrder->viewer()->lblCompletedAt }}</dd>

    <p></p>

</dl>
