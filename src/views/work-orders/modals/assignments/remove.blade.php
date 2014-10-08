<div id="assigned-workers">
    @if($workOrder->hasWorkersAssigned())

    <h4>Current Assigned Workers</h4>

    <table class="table table-bordered table-condensed table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Assigned</th>
                <th>Remove</th>
            </tr>
        </thead>
        <tbody>
            @foreach($workOrder->assignments as $assignment)
            <tr>
                <td>{{ $assignment->toUser->full_name }}</td>
                <td>{{ $assignment->created_at }}</td>
                <td>
                    {{ Form::open(array(
                                'url'=>route('maintenance.work-orders.assignments.destroy', array($workOrder->id, $assignment->id)),
                                'method'=>'DELETE',
                                'class'=>'ajax-form-post',
                                'data-refresh-target'=>'#assigned-workers',
                                'data-status-target' => '#workers-assigned-status'
                            ))
                    }}
                    
                    <button 
                        type="submit" 
                        class="btn btn-primary confirm"
                        data-confirm-message="{{ sprintf('Are you sure you want to remove <b>%s</b> from this work order?', $assignment->toUser->full_name) }}"
                        ><i class="fa fa-trash-o"></i> Remove</button>
                    
                    {{ Form::close() }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @else
    <h5>There are currently no workers assigned to this work order.</h5>
    @endif
    
</div>