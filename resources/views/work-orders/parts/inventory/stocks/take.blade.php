@extends('layouts.pages.main.panel')

@section('title', 'Take Parts')

@section('panel.head.content')
    Enter the Quantity Used
@stop

@section('panel.body.content')
    <legend>Stock Details</legend>

    <dl class="dl-horizontal">
        <dt>Item:</dt>
        <dd>{{ $item->name }}</dd>

        <p></p>

        <dt>Location:</dt>
        <dd>{!! $stock->location->trail !!}</dd>

        <p></p>

        <dt>Current Stock:</dt>
        <dd id="quantity-refresh">{{ $stock->quantity }}</dd>

        <p></p>
    </dl>

    <hr>

    {!!
        Form::open([
            'url' => route('maintenance.work-orders.parts.stocks.take', [$workOrder->id, $item->id, $stock->id]),
            'class' => 'form-horizontal',
        ])
    !!}

    <div class="form-group{{ $errors->first('quantity', ' has-error') }}">
        <label class="col-sm-2 control-label">Quantity Taken / Used</label>

        <div class="col-md-4">
            <div class="input-group">
                {!! Form::text('quantity', null, ['class'=>'form-control', 'placeholder'=>'ex. 45']) !!}
                <span class="input-group-addon">{{ $item->metric->symbol }}</span>
            </div>

            <span class="label label-danger">{{ $errors->first('quantity', ':message') }}</span>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {!! Form::submit('Save', array('class'=>'btn btn-primary')) !!}
        </div>
    </div>

    {!! Form::close() !!}
@stop
