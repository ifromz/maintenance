{{ Form::open(array(
            'url'=>route('maintenance.work-orders.parts.stocks.put-back', array($workOrder->id, $stock->item->id, $stock->id)), 
            'class'=>'ajax-form-post',
            'data-refresh-target'=>'#content'
        ))
}}

<button
    type="submit" 
    class="btn btn-primary confirm"
    data-confirm-message="Are you sure you want to put back {{ $stock->pivot->quantity }} of {{ $stock->item->name }}?"
    >
    <i class="fa fa-reply"></i> Put Back
</button>

{{ Form::close() }}
