<a href="{{ route('maintenance.admin.archive.work-orders.restore', array($workOrder->id)) }}"
   data-method="post"
   data-title="Restore Work Order?"
   data-message="Are you sure you want to restore this work order?"
   class="btn btn-app">
    <i class="fa fa-refresh"></i> Restore
</a>