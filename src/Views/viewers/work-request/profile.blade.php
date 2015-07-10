<table class="table">
    <tbody>
        <tr>
            <th>Current Status</th>
            @if($workRequest->workOrder && $workRequest->workOrder->status)
                <td>{!! $workRequest->workOrder->status->label !!}</td>
            @else
                <em>None</em>
            @endif
        </tr>
        <tr>
            <th>Submitted By</th>
            <td>{{ $workRequest->user->full_name }}</td>
        </tr>
        <tr>
            <th>Best Time</th>
            <td>{{ $workRequest->best_time }}</td>
        </tr>
        <tr>
            <th>Subject</th>
            <td>{{ $workRequest->subject }}</td>
        </tr>
        <tr>
            <th>Description</th>
            <td>{!! $workRequest->description !!}</td>
        </tr>
    </tbody>
</table>
