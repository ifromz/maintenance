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

    @if($item->hasSku())
        <dt>SKU:</dt>
        <dd>{{ $item->getSku() }}</dd>

        <p></p>
    @endif

    <dt>Metric:</dt>
    <dd>{{ $item->metric->name }}</dd>

    <p></p>

    <dt>Description:</dt>
    <dd class="well">
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

    <dt>QR Code:</dt>
    <dd>
        <a class="btn btn-xs btn-primary" data-toggle="collapse" href="#qr-code" aria-expanded="false" aria-controls="collapse-qr-code">
            Show / Hide QR
        </a>

        <div class="collapse" id="qr-code">
            <div class="well">
                {{ QrCode::size(200)->generate(Request::url()); }}
            </div>
        </div>
    </dd>
</dl>
