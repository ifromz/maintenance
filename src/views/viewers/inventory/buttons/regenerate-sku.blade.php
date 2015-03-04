<a href="{{ route('maintenance.inventory.sku.regenerate', array($item->id)) }}"
   data-method="PATCH"
   data-title="Are you sure?"
   data-message="Are you sure you want to regenerate the SKU for this item?"
   class="btn btn-app no-print"
        >
    <i class="fa fa-refresh"></i> Regenerate SKU
</a>