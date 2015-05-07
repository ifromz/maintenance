<div class="form-group">
    <label class="col-sm-2 control-label">Subject</label>

    <div class="col-md-6">
        {{ Form::text('subject', (isset($workRequest) ? $workRequest->subject : null), array('class'=>'form-control', 'placeholder'=>'Enter Subject')) }}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Best Time</label>

    <div class="col-md-6">
        {{ Form::text('best_time', (isset($workRequest) ? $workRequest->best_time : null), array('class'=>'form-control', 'placeholder'=>'Enter Best Time')) }}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Description</label>

    <div class="col-md-6">
        {{ Form::textarea('description', (isset($workRequest) ? $workRequest->description : null)) }}
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {{ Form::submit('Save', array('class'=>'btn btn-primary')) }}
    </div>
</div>
