<legend>Sessions & Hours</legend>

@if($workOrder->sessions->count() > 0)

    <table class="table table-striped">
        <thead>
        <tr>
            <th>
                Worker
            </th>
            <th>
                In
            </th>
            <th>
                Out
            </th>
            <th>
                Hours
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($workOrder->sessions as $session)
            <tr>
                <td>
                    {{ $session->user->fullname }}
                </td>
                <td>
                    {{ $session->in }}
                </td>
                <td>
                    @if($session->out)
                        {{ $session->out }}
                    @else
                        <span class="label label-success">Currently Open</span>
                    @endif
                </td>
                <td>
                    {{ $session->hours }}
                </td>
            </tr>
        @endforeach
        <tr>
            <td class="text-underline"><b>Total:</b></td>
            <td></td>
            <td></td>
            <td>{{ $workOrder->sessions->sum('hours') }}</td>
        </tr>
        </tbody>
    </table>
@else

    <h5>No workers have checked into this work order.</h5>

@endif
