<dl class="dl-horizontal">
    <dt>Name:</dt>
    <dd>{{ $asset->name }}</dd>

    <p></p>

    <dt>Added:</dt>
    <dd>{{ $asset->created_at }}</dd>

    <p></p>

    <dt>Added By:</dt>
    <dd>{{ $asset->user->full_name }}</dd>

    <p></p>

    <dt>Aquired At:</dt>
    <dd>{{ ($asset->aquired_at ? $asset->aquired_at : '<em>None</em>') }}</dd>

    @if($asset->location)
    <p></p>
    <dt>Location:</dt>
    <dd>
        {{ renderNode($asset->location) }}
    </dd>
    @endif

    <p></p>

    <dt>Category:</dt>
    <dd>{{ renderNode($asset->category) }}</dd>
</dl>