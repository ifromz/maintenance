<legend>Profile</legend>

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

<a href=""
    data-target="#assign-workers-modal"
    data-toggle="modal"
    class="btn btn-app">
    <i class="fa fa-users"></i> Workers
</a>

@if(!$workOrder->report)
<a href=""
   data-target="#complete-work-order-modal"
   data-toggle="modal"
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
   data-message="Are you sure you want to delete this work order? This will also remove all updates, parts used, photos, history and assignments." 
   class="btn btn-app">
    <i class="fa fa-trash-o"></i> Delete
</a>

<div class="clearfix"></div>

<hr>

<dl class="dl-horizontal">

    @if($workOrder->isComplete() && !$workOrder->report)
        <div class="alert alert-warning">
            <b>Heads Up!</b> This work order is closed, but no report has been submitted detailing it's completion. 
            You should probably fill one out by clicking the <b>Complete</b> button above.
        </div>
    @endif
    
    <dt>Status:</dt>
    <dd>{{ $workOrder->status_label }}</dd>

    <p></p>

    <dt>Created By:</dt>
    <dd>{{ $workOrder->user->full_name }}</dd>

    <p></p>

    <dt>Subject:</dt>
    <dd>{{ $workOrder->subject }}</dd>

    <p></p>
    
    @if($workOrder->description)
        <dt>Description:</dt>
        <dd>{{ $workOrder->description }}</dd>

        <p></p>
    @endif
    
    @if($workOrder->assets->count() > 0)
        <dt>Assets Involved:</dt>
        <dd>
            @foreach($workOrder->assets as $asset)
                {{ $asset->label }}
            @endforeach
        </dd>

        <p></p>
    @endif
</dl>

@include('maintenance::work-orders.modals.assignments.create', array('workOrder'=>$workOrder))
@include('maintenance::work-orders.modals.complete', array('workOrder'=>$workOrder))

                    