<!-- Chat box -->
<div class="box box-default no-border">
    <div class="box-header">
        <i class="fa fa-refresh"></i>
        <h3 class="box-title">
            Customer Updates
        </h3>
    </div>
    <div class="box-body chat" id="chat-box">
        <!-- chat item -->
        @foreach($workOrder->customerUpdates as $update)
                @include('maintenance::partials.update', array('workOrder'=>$workOrder, 'update'=>$update))
        @endforeach
    </div><!-- /.chat -->
    <div class="box-footer">
    {{ Form::open(array('url'=>route('maintenance.work-orders.updates.store', array($workOrder->id)), 'id'=>'work-order-update')) }}
        <div class="input-group">
            <input name="update_content" class="form-control" placeholder="Type an update..."/>
            <div class="input-group-btn">
                <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i></button>
            </div>    
        </div>
        {{ Form::close() }}
    </div>
</div><!-- /.box (chat box) -->