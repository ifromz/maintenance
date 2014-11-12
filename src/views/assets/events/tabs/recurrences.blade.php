
<div id="resource-paginate">
    
    @if($recurrences->count() > 0)
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Start</th>
                <th>End</th>
                <th>All Day</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recurrences as $recurrence)
            <tr>
                <td>{{ $recurrence->start_formatted }}</td>
                <td>{{ $recurrence->end_formatted }}</td>
                <td>{{ $recurrence->all_day_label }}</td>
                <td>
                    <div class="btn-group">
                        <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                            Action
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a 
                                    href="{{ route('maintenance.assets.events.destroy-recurrence', array($asset->id, $event->id, $recurrence->id)) }}" 
                                    data-method="delete"
                                    data-message="Are you sure you want to delete this recurrence?">
                                    <i class="fa fa-trash-o"></i> Delete Recurrence
                                </a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    @else
    
    <h5>There are no recurrences that have been generated yet for this event.</h5>
    
    @endif
    
    <div class="btn-toolbar text-center">
        {{ $recurrences->appends(Input::except('page'))->links() }}
    </div>
</div>