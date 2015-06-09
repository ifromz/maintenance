<table class="table">
    <tbody>
        <tr>
            <th>Name</th>
            <td>{{ $asset->name }}</td>
        </tr>
        <tr>
            <th>Added</th>
            <td>{{ $asset->created_at }}</td>
        </tr>
        <tr>
            <th>Category</th>
            <td>{!! $asset->category->trail !!}</td>
        </tr>
        <tr>
            <th>Condition</th>
            <td>{{ $asset->condition }}</td>
        </tr>
        @if($asset->user)
            <tr>
                <th>Added By</th>
                <td>{{ $asset->user->full_name }}</td>
            </tr>
        @endif
        @if($asset->acquired_at)
            <tr>
                <th>Acquired At</th>
                <td>{{ $asset->acquired_at }}</td>
            </tr>
        @endif
        @if($asset->end_of_life)
            <tr>
                <th>End of Life</th>
                <td>{{ $asset->end_of_life }}</td>
            </tr>
        @endif
    </tbody>
</table>
