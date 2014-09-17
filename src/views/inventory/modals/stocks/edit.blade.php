
<div id="inventory-stock-update-alert"></div>

{{ Form::open(array(
            'url'=>route('maintenance.inventory.stocks.update', array($item->id, $stock->id)),
            'method'=>'PATCH',
            'class'=>'form-horizontal', 
            'data-refresh' => '#inventory-stocks-table',
            'id'=>'maintenance-inventory-stocks-edit'
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
        {{ Form::text('quantity', $stock->quantity, array('class'=>'form-control', 'placeholder'=>'ex. 45')) }}
    </div>
</div>


<div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
        {{ Form::submit('Save', array('class'=>'btn btn-primary')) }}
    </div>
</div>

{{ Form::close() }}