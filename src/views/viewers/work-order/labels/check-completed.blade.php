@if($workOrder->isComplete())
    <span class="btn btn-sm disabled btn-success">
        Yes
        <i class="fa fa-check"></i>
    </span>
@else
    <span class="btn btn-sm disabled btn-danger">
        No
        <i class="fa fa-times"></i>
    </span>
@endif
