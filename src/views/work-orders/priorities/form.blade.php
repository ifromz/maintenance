<legend class="margin-top-10">Priority Information</legend>

<div class="form-group">
    <label class="col-sm-2 control-label">Name</label>

    <div class="col-md-4">
        {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'ex. Awaiting Parts / Supplies']) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Color</label>

    <div class="col-md-4">
        @include('maintenance::select.color')
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit('Save', array('class'=>'btn btn-primary')) !!}
    </div>
</div>