
<legend>Completion Report</legend>

@if($workOrder->report)

<dl class="dl-horizontal">
    <dt>Created By:</dt>
    <dd>{{ $workOrder->report->user->full_name }}</dd>
    
    <p></p>
    
    <dt>Written On:</dt>
    <dd>{{ $workOrder->report->created_at }}</dd>
    
    <p></p>
    
    <dt>Report:</dt>
    <dd>{{ $workOrder->report->description }}</dd>
</dl>

@else

<h5>No report has been created for this work order.</h5>

@endif