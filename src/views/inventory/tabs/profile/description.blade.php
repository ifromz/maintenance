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

    <dt>Category:</dt>
    <dd>{{ renderNode($item->category) }}</dd>

    <p></p>
    
    @if($item->description)
        <dt>Description:</dt>
        <dd class="pad bg-gray">{{ $item->description }}</dd>
        
        <p></p>
    @endif
</dl>