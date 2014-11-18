<a class="btn btn-app no-print" data-toggle="modal" data-target="#qr-modal">
    <i class="fa fa-qrcode"></i> QR Code
</a>

@include('maintenance::partials.qr-modal', array(
    'id' => 'qr-modal',
    'title' => 'QR Code',
    'content' => route('maintenance.assets.show', array($asset->id)))
)

<a href="{{ route('maintenance.assets.calendars.index', array($asset->id)) }}" class="btn btn-app no-print">
    <i class="fa fa-calendar"></i> Calendars
</a>

<a href="{{ route('maintenance.assets.images.create', array($asset->id)) }}" class="btn btn-app no-print">
    <i class="fa fa-plus-circle"></i> Add Images
</a>

<a href="{{ route('maintenance.assets.images.index', array($asset->id)) }}" class="btn btn-app no-print">
    <i class="fa fa-search"></i> View Images
</a>

<a href="{{ route('maintenance.assets.edit', array($asset->id)) }}" class="btn btn-app no-print">
    <i class="fa fa-edit"></i> Edit
</a>

<a href="{{ route('maintenance.assets.destroy', array($asset->id)) }}" 
    data-method="delete"
    data-title="Delete asset?"
    data-message="Are you sure you want to delete this asset? This asset will archived. No data will be lost, however you will not be able to restore it without manager/supervisor
    permission." 
    class="btn btn-app no-print">
     <i class="fa fa-trash-o"></i> Delete
 </a>