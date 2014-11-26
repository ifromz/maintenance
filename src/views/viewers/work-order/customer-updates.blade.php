<!-- Chat box -->

<legend>Customer Updates</legend>

<div class="box box-solid">
    <div class="box-body chat" id="chat-box">
        <!-- chat item -->
        @foreach($workOrder->customerUpdates as $update)
                @include('maintenance::partials.update', array('workOrder'=>$workOrder, 'update'=>$update))
        @endforeach
    </div><!-- /.chat -->
    
    <div class="box-footer">
        {{ Form::open(array(
                    'url'=>route('maintenance.work-orders.updates.store', array($workOrder->id)), 
                    'class'=>'ajax-form-post clear-form', 
                    'data-refresh-target'=>'#chat-box'
                ))
        }}
        <div class="input-group">
            <input name="update_content" class="form-control" placeholder="Type an update..."/>
            <div class="input-group-btn">
                <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i></button>
            </div>    
        </div>
        {{ Form::close() }}
    </div>
</div>