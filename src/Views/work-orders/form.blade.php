<div class="form-group{{ $errors->first('category', ' has-error') }}">
    <label class="col-sm-2 control-label">Category</label>

    <div class="col-md-4">
        @include('maintenance::select.work-order-category', [
              'category_name'=>(isset($workOrder) ? ($workOrder->category ? $workOrder->category->name : null) : null),
              'category_id'=>(isset($workOrder) ? ($workOrder->category ? $workOrder->category->id : null) : null)
        ])

        <span class="label label-danger">{{ $errors->first('category_id', ':message') }}</span>
        <span class="label label-danger">{{ $errors->first('category_name', ':message') }}</span>
    </div>
</div>

<div class="form-group{{ $errors->first('location', ' has-error') }}">
    <label class="col-sm-2 control-label">Location</label>

    <div class="col-md-4">
        @include('maintenance::select.location', [
              'location_name'=>(isset($workOrder) ? ($workOrder->location ? $workOrder->location->name : null) : null),
              'location_id' => (isset($workOrder) ? ($workOrder->location ? $workOrder->location->id : null) : null),
        ])

        <span class="label label-danger">{{ $errors->first('location_id', ':message') }}</span>
        <span class="label label-danger">{{ $errors->first('location_name', ':message') }}</span>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label{{ $errors->first('status', ' has-error') }}">Status</label>

    <div class="col-md-4">
        @include('maintenance::select.status', [
            'status'=> (isset($workOrder) ? $workOrder->status->id : null)
        ])

        <span class="label label-danger">{{ $errors->first('status', ':message') }}</span>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label{{ $errors->first('priority', ' has-error') }}">Priority</label>

    <div class="col-md-4">
        @include('maintenance::select.priority', [
            'priority'=> (isset($workOrder) ? $workOrder->priority->id : null)
        ])

        <span class="label label-danger">{{ $errors->first('priority', ':message') }}</span>
    </div>
</div>

<div class="form-group{{ $errors->first('assets', ' has-error') }}">
    <label class="col-sm-2 control-label">Assets Involved</label>

    <div class="col-md-4">
        @include('maintenance::select.assets', [
            'assets'=> (isset($workOrder) ? $workOrder->assets->lists('id')->toArray() : null)
        ])

        <span class="label label-danger">{{ $errors->first('assets', ':message') }}</span>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label{{ $errors->first('subject', ' has-error') }}">Subject</label>

    <div class="col-md-4">
        {!! Form::text('subject', (isset($workOrder) ? $workOrder->subject : null), ['class'=>'form-control', 'placeholder'=>'ex. Worked on HVAC']) !!}

        <span class="label label-danger">{{ $errors->first('subject', ':message') }}</span>
    </div>
</div>

<div class="form-group{{ $errors->first('description', ' has-error') }}">
    <label class="col-sm-2 control-label">Description / Details</label>

    <div class="col-md-4">
        {!! Form::textarea('description', (isset($workOrder) ? htmlspecialchars($workOrder->description) : null), ['class'=>'form-control', 'style'=>'min-width:100%']) !!}

        <span class="label label-danger">{{ $errors->first('description', ':message') }}</span>
    </div>
</div>


<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit('Save', ['class'=>'btn btn-primary']) !!}
    </div>
</div>
