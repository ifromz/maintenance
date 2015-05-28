<div class="form-group">
    <label class="col-sm-2 control-label">Name</label>

    <div class="col-md-4">
        {!! Form::text('name', (isset($metric) ? $metric->name : null), ['class'=>'form-control', 'placeholder'=>'ex. Kilometers']) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Symbol</label>

    <div class="col-md-4">
        {!! Form::text('symbol', (isset($metric) ? $metric->symbol : null), ['class'=>'form-control', 'placeholder'=>'Kms']) !!}
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit('Save', ['class'=>'btn btn-primary']) !!}
    </div>
</div>
