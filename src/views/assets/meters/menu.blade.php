<a href="{{ route('maintenance.assets.meters.edit', array($asset->id, $meter->id)) }}" class="btn btn-app no-print">
    <i class="fa fa-edit"></i> Edit
</a>

<a href="{{ route('maintenance.assets.meters.destroy', array($asset->id, $meter->i)) }}"
   data-method="delete"
   data-title="Delete meter?"
   data-message="Are you sure you want to delete this meter? All readings will be lost."
   class="btn btn-app no-print">
    <i class="fa fa-trash-o"></i> Delete
</a>