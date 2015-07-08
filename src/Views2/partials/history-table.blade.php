@if(isset($record))
    <h2>History</h2>

    @if($record->revisionHistory->count() > 0)

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>User Responsible</th>
                    <th>Changed</th>
                    <th>From</th>
                    <th>To</th>
                    <th>On</th>
                </tr>
            </thead>
            <tbody>
            @foreach($record->revisionHistory as $record)
                <tr>
                    <td>{{ $record->userResponsible()->first_name }} {{ $record->userResponsible()->last_name }}</td>
                    <td>{{ $record->fieldName() }}</td>
                    <td>
                        @if(is_null($record->oldValue()))
                            <em>None</em>
                        @else
                            {!! $record->oldValue() !!}
                        @endif

                    </td>
                    <td>{!! $record->newValue() !!}</td>
                    <td>{{ $record->created_at }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    @else

        <h5>There is no history to display.</h5>

    @endif
@endif
