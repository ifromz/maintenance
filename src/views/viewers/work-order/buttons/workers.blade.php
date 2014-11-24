<a data-target="#assign-workers-modal"
    data-toggle="modal"
    class="btn btn-app">
    <i class="fa fa-users"></i> Workers
</a>


<div class="modal fade" id="assign-workers-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Assign Workers to this Work Order</h4>
            </div>
            
            <div class="modal-body">
                
                <div id="workers-assigned-status"></div>
                
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
                
                <hr>
                
                {{ Form::open(array(
                        'url'=>route('maintenance.work-orders.assignments.store', array($workOrder->id)), 
                        'class'=>'ajax-form-post', 
                        'data-refresh-target'=>'#assigned-workers',
                        'data-status-target'=>'#workers-assigned-status'
                    )) 
                }}
                
                <label>Enter Names</label>
                @include('maintenance::select.users')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            {{ Form::close() }}
            
        </div>
    </div>
</div>