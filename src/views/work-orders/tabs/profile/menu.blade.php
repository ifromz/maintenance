
@if($workOrder->userCheckedIn())

    <a href="{{ route('maintenance.work-orders.session.end', array($workOrder->id, $workOrder->getCurrentSession()->id)) }}" 
        data-method="post"
        data-title="Check out?"
        data-message="Are you sure you want to check <b>out</b> this work order?" 
        class="btn btn-app"
        >
        <i class="fa fa-clock-o"></i> Check Out
    </a>

@else

    <a href="{{ route('maintenance.work-orders.session.start', array($workOrder->id)) }}" 
        data-method="post" 
        data-title="Check in?"
        data-message="Are you sure you want to check <b>into</b> this work order?" 
        class="btn btn-app"
        >
        <i class="fa fa-clock-o"></i> Check In
    </a>

@endif

<a data-target="#assign-workers-modal"
    data-toggle="modal"
    class="btn btn-app">
    <i class="fa fa-users"></i> Workers
</a>

@if(!$workOrder->report)

    <a href="{{ route('maintenance.work-orders.report.create', array($workOrder->id)) }}"
       class="btn btn-app">
        <i class="fa fa-check-circle-o"></i> Complete
    </a>

@endif

<a href="{{ route('maintenance.work-orders.edit', array($workOrder->id)) }}" class="btn btn-app">
    <i class="fa fa-edit"></i> Edit
</a>

<a href="{{ route('maintenance.work-orders.destroy', array($workOrder->id)) }}" 
   data-method="delete"
   data-title="Delete work order?"
   data-message="Are you sure you want to delete this work order? This work order will be archived. 
   No data will be lost, however you will not be able to restore it without manager/supervisor permission." 
   class="btn btn-app">
    <i class="fa fa-trash-o"></i> Delete
</a>
