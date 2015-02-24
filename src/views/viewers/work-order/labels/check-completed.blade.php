@if($workOrder->isComplete())
    <span class="btn btn-sm disabled btn-success">
        <i class="fa fa-check"></i>
    </span>
@else
    <span class="btn btn-sm disabled btn-danger">
        <i class="fa fa-times"></i>
    </span>
@endif