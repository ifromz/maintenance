<div class="modal fade" id="complete-work-order-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(array('url'=>route('maintenance.work-orders.report.store', array($workOrder->id)))) }}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Completion Report</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="location_name">Description</label>
                    <div class="col-md-12">
                        {{ Form::textarea('description', null, array('class'=>'form-control')) }}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>