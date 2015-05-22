<table class="table">
    <tbody>
        <tr>
            <th>Created By</th>
            <td>{{ $workRequest->user->full_name }}</td>
        </tr>
        <tr>
            <th>Best Time</th>
            <td>{{ $workRequest->best_time }}</td>
        </tr>
        <tr>
            <th>Subject</th>
            <td>{{ $workRequest->suject }}</td>
        </tr>
        <tr>
            <th>Description</th>
            <td>{{ $workRequest->description }}</td>
        </tr>
    </tbody>
</table>
