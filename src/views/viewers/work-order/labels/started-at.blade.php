@if($workOrder->started_at)
    <span class="label label-success">{{ $workOrder->viewer()->startedAtFormatted }}</span>
@else
    <span class="label label-danger">Hasn't been started yet</span>
@endif