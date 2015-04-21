<dl class="dl-horizontal">
    <dt>Name:</dt>
    <dd>{{ $asset->name }}</dd>

    <p></p>

    <dt>Added:</dt>
    <dd>{{ $asset->created_at }}</dd>

    <p></p>

    <dt>Added By:</dt>
    <dd>
        @if($asset->user)
            {{ $asset->user->full_name }}
        @else
            <em>None</em>
        @endif
    </dd>

    <p></p>

    <dt>Acquired At:</dt>
    <dd>{{ ($asset->acquired_at ? $asset->acquired_at : '<em>None</em>') }}</dd>

    @if($asset->location)
        <p></p>
        <dt>Location:</dt>
        <dd>
            {{ $asset->location->trail }}
        </dd>
    @endif

    <p></p>

    <dt>Category:</dt>
    <dd>{{ $asset->category->trail }}</dd>
</dl>