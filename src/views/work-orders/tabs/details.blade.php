@if($workOrder->report)
<legend>Completion Report</legend>

<dl class="dl-horizontal">
    <dt>Created By:</dt>
    <dd>{{ $workOrder->report->user->full_name }}</dd>
    
    <p></p>
    
    <dt>Written On:</dt>
    <dd>{{ $workOrder->report->created_at }}</dd>
    
    <p></p>
    
    <dt>Report</dt>
    <dd>{{ $workOrder->report->description }}</dd>
</dl>
@endif