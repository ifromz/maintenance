<div class="form-group">
    <label class="col-sm-2 control-label" for="location_name">Name</label>

    <div class="col-md-4">
        {{ Form::text('name', (isset($category) ? $category->name : null), array('class'=>'form-control', 'placeholder'=>'ex. Electrical / Lighting')) }}
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {{ Form::submit('Save', array('class'=>'btn btn-primary')) }}
    </div>
</div>
