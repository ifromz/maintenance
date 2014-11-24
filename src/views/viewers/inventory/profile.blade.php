<dl class="dl-horizontal">
    @if($item->user)
    <dt>Created By:</dt>
    <dd>{{ $item->user->full_name }}</dd>

    <p></p>
    @endif

    <dt>Added:</dt>
    <dd>{{ $item->created_at }}</dd>

    <p></p>

    <dt>Name:</dt>
    <dd>{{ $item->name }}</dd>

    <p></p>
    
    <dt>Metric:</dt>
    <dd>{{ $item->metric->name }}</dd>

    <p></p>
    
    <dt>Description:</dt>
    <dd class="pad bg-gray">
        @if($item->description)
            {{ $item->description }}
        @else
            <em>None</em>
        @endif
    </dd>
    
    <p></p>
    
    <dt>Category:</dt>
    <dd>{{ renderNode($item->category) }}</dd>

    <p></p>
</dl>