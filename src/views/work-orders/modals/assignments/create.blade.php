<div class="modal fade" id="assign-workers-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Assign Workers to this Work Order</h4>
            </div>
            <div class="modal-body">
                <div id="workers-assigned-status"></div>
                
                @include('maintenance::work-orders.modals.assignments.remove', array(
                    'workOrder'=>$workOrder
                ))
                
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