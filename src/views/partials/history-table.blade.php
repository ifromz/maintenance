
@if(isset($history))
<table class="table table-striped">
    <thead>
        <tr>
            <th>User Responsible</th>
            <th>Changed</th>
            <th>From</th>
            <th>To</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($item->revisionHistory as $record)
        <tr>
            <td>{{ $record->userResponsible()->first_name }} {{ $record->userResponsible()->last_name }}</td>
            <td>{{ $record->fieldName() }}</td>
            <td>{{ $record->oldValue() }}</td>
            <td>{{ $record->newValue() }}</td>
            <td>{{ $record->created_at }}</td>
            
        </tr>
        @endforeach
    </tbody>
</table>

@else
<h5>There is no history to display</h5>
@endif