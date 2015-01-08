
<div id="inventory-stock-update-alert"></div>

{{ Form::open(array(
            'url'=>route('maintenance.inventory.stocks.update', array($item->id, $stock->id)),
            'method'=>'PATCH',
            'class'=>'form-horizontal ajax-form-post', 
            'data-refresh-target' =>'#inventory-stocks-table',
            'data-status-target'=>'#inventory-stock-update-alert'
        ))
}}
<legend class="margin-top-10">Enter New Quantity</legend>

<div class="form-group">
    <label class="col-sm-2 control-label">Location</label>
    <div class="col-md-10">
        @include('maintenance::select.location', array(
            'location_name' => $stock->location->name,
            'location_id' => $stock->location->id
        ))
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Quantity</label>
    <div class="col-md-10">
        <div class="input-group">
            {{ Form::text('quantity', $stock->quantity, array('class'=>'form-control', 'placeholder'=>'ex. 45')) }}

            @if($item->metric)
                <span class="input-group-addon">{{ $item->metric->symbol }}</span>
            @endif
        </div>
    </div>
</div>



<div class="form-group">
    <label class="col-sm-2 control-label">Reason</label>
    <div class="col-md-10">
        {{ Form::text('reason', "Stock Adjustment", array('class'=>'form-control', 'placeholder'=>'ex. Stock was Moved')) }}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Cost</label>
    <div class="col-md-10">

        <div class="input-group">
            <span class="input-group-addon">$</span>
            {{ Form::text('cost', NULL, array('class'=>'form-control', 'placeholder'=>'ex. 15.00')) }}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {{ Form::submit('Save', array('class'=>'btn btn-primary')) }}
    </div>
</div>

{{ Form::close() }}