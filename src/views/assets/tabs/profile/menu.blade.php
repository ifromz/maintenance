<a class="btn btn-app" data-toggle="modal" data-target="#qr-modal">
    <i class="fa fa-qrcode"></i> QR Code
</a>

@include('maintenance::partials.qr-modal', array(
    'id' => 'qr-modal',
    'title' => 'QR Code',
    'content' => route('maintenance.assets.show', array($asset->id)))
)

<a href="{{ route('maintenance.assets.events.index', array($asset->id)) }}" class="btn btn-app">
    <i class="fa fa-calendar"></i> Events
</a>

<a href="{{ route('maintenance.assets.images.create', array($asset->id)) }}" class="btn btn-app">
    <i class="fa fa-plus-circle"></i> Add Images
</a>

<a href="{{ route('maintenance.assets.images.index', array($asset->id)) }}" class="btn btn-app">
    <i class="fa fa-search"></i> View Images
</a>

<a href="{{ route('maintenance.assets.edit', array($asset->id)) }}" class="btn btn-app">
    <i class="fa fa-edit"></i> Edit
</a>

<a href="{{ route('maintenance.assets.destroy', array($asset->id)) }}" 
    data-method="delete"
    data-title="Delete asset?"
    data-message="Are you sure you want to delete this asset? This will remove any maintenance schedules attached to this asset, as well as manuals, images, and work orders." 
    class="btn btn-app">
     <i class="fa fa-trash-o"></i> Delete
 </a>