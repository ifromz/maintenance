@if($workOrder->completed_at)
    <span class="label label-success">{{ $workOrder->viewer()->completedAtFormatted }}</span>
@else
    <span class="label label-danger">No Report has been filled</span>
@endif