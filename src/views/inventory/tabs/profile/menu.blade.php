<a href="#test" class="btn btn-app no-print" data-toggle="modal" data-target="#qr-modal">
    <i class="fa fa-qrcode"></i> QR Code
</a>
    
    @include('maintenance::partials.qr-modal', array(
        'id' => 'qr-modal',
        'title' => 'QR Code',
        'content' => route('maintenance.inventory.show', array($item->id))
    ))

<a href=""
   data-target="#create-stock-modal"
   data-toggle="modal"
   class="btn btn-app no-print">
    <i class="fa fa-plus-circle"></i> Add Stock
</a>

<a href="{{ route('maintenance.inventory.edit', array($item->id)) }}"
    class="btn btn-app no-print"
    >
    <i class="fa fa-pencil"></i> Edit Item
</a>

<a href="{{ route('maintenance.inventory.destroy', array($item->id)) }}"
   data-method="DELETE"
   data-title="Are you sure?"
   data-message="Are you sure you want to delete this item? This will be archived. No data will be lost, however you will not be able to restore it without manager/supervisor
    permission."
    class="btn btn-app no-print"
    >
    <i class="fa fa-trash-o"></i> Delete Item
</a>