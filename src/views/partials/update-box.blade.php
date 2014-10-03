<!-- Chat box -->

    <div class="box-header">
        <h3>
            Customer Updates
        </h3>
    </div>
    <div class="chat" id="chat-box">
        <!-- chat item -->
        @foreach($workOrder->customerUpdates as $update)
                @include('maintenance::partials.update', array('workOrder'=>$workOrder, 'update'=>$update))
        @endforeach
    </div><!-- /.chat -->
    
    {{ Form::open(array('url'=>route('maintenance.work-orders.updates.store', array($workOrder->id)), 'id'=>'work-order-update')) }}
    <div class="input-group">
        <input name="update_content" class="form-control" placeholder="Type an update..."/>
        <div class="input-group-btn">
            <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i></button>
        </div>    
    </div>
    {{ Form::close() }}