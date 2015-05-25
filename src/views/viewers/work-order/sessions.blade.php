<h2>Sessions & Hours</h2>

@if(isset($sessions) AND count($sessions) > 0)

    <table class="table table-striped">
        <thead>
        <tr>
            <th>
                Worker
            </th>
            <th>
                Total Hours
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($sessions as $session)
            <tr>
                <td>
                    {{ $session->user->fullname }}
                </td>
                <td>
                    @if($session->total_hours)
                        {{ $session->total_hours }}
                    @else
                        0
                    @endif
                </td>
            </tr>
        @endforeach
        <tr>
            <td class="text-underline"><b>Total:</b></td>
            <td>{{ $sessions->sum('total_hours') }}</td>
        </tr>
        </tbody>
    </table>
@else

    <h5>No workers have checked into this work order.</h5>

@endif
