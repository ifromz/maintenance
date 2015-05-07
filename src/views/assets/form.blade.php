<legend class="margin-top-10">Required Information</legend>

<div class="form-group">
    <label class="col-sm-2 control-label" for="name">Name</label>

    <div class="col-md-4">
        {{ Form::text('name', (isset($asset) ? $asset->name : null), array('class'=>'form-control', 'placeholder'=>'ex. Ford F150')) }}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="name">Condition</label>

    <div class="col-md-4">
        {{ Form::select('condition', trans('maintenance::assets.conditions'), (isset($asset) ? $asset->condition_number : null), array('class'=>'form-control select2')) }}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="name">Category</label>

    <div class="col-md-4">
        @include('maintenance::select.asset-category', array(
            'category_name'=>(isset($asset) ? $asset->category->name : null),
            'category_id'=> (isset($asset) ? $asset->category->id : null)
        ))
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="name">Location</label>

    <div class="col-md-4">
        @include('maintenance::select.location', array(
            'location_name'=> (isset($asset) ? $asset->location->name : null),
            'location_id' => (isset($asset) ? $asset->location->id : null)
        ))
    </div>
</div>

<legend class="margin-top-10">Other Information</legend>
<div class="form-group">
    <label class="col-sm-2 control-label" for="name">Vendor</label>

    <div class="col-md-4">
        {{ Form::text('vendor', (isset($asset) ? $asset->vendor : null), array('class'=>'form-control', 'placeholder'=>'ex. Ford')) }}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="name">Make</label>

    <div class="col-md-4">
        {{ Form::text('make', (isset($asset) ? $asset->make : null), array('class'=>'form-control', 'placeholder'=>'ex. F')) }}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="name">Model</label>

    <div class="col-md-4">
        {{ Form::text('model', (isset($asset) ? $asset->model : null), array('class'=>'form-control', 'placeholder'=>'ex. 150')) }}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="name">Serial</label>

    <div class="col-md-4">
        {{ Form::text('serial', (isset($asset) ? $asset->serial : null), array('class'=>'form-control', 'placeholder'=>'ex. 153423-13432432-2342423')) }}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="name">Size</label>

    <div class="col-md-4">
        {{ Form::text('size', (isset($asset) ? $asset->size : null), array('class'=>'form-control', 'placeholder'=>'ex. 1905 x 2463')) }}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="name">Weight</label>

    <div class="col-md-4">
        {{ Form::text('weight', (isset($asset) ? $asset->weight : null), array('class'=>'form-control', 'placeholder'=>'ex. 1 ton')) }}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="name">Aquisition Date</label>

    <div class="col-md-4">
        {{ Form::text('acquired_at', (isset($asset) ? $asset->aquired_at : null), array('class'=>'pickadate form-control', 'placeholder'=>'Click to Select Date')) }}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="name">End of Life Date</label>

    <div class="col-md-4">
        {{ Form::text('end_of_life', (isset($asset) ? $asset->end_of_life : null), array('class'=>'pickadate form-control', 'placeholder'=>'Click to Select Date')) }}
    </div>
</div>

<div class="form-group">
    <div class="col-md-4 col-md-offset-2">
        {{ Form::submit('Save', array('class'=>'btn btn-primary')) }}
    </div>
</div>
