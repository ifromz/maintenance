<div class="form-group{{ $errors->first('name', ' has-error') }}">
    <label class="col-sm-2 control-label">Name</label>

    <div class="col-md-4">
        {!! Form::text('name', (isset($metric) ? $metric->name : null), ['class'=>'form-control', 'placeholder'=>'ex. Kilometers']) !!}

        <span class="label label-danger">{{ $errors->first('name', ':message') }}</span>
    </div>
</div>

<div class="form-group{{ $errors->first('symbol', ' has-error') }}">
    <label class="col-sm-2 control-label">Symbol</label>

    <div class="col-md-4">
        {!! Form::text('symbol', (isset($metric) ? $metric->symbol : null), ['class'=>'form-control', 'placeholder'=>'Kms']) !!}

        <span class="label label-danger">{{ $errors->first('symbol', ':message') }}</span>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit('Save', ['class'=>'btn btn-primary']) !!}
    </div>
</div>
