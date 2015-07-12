@extends('maintenance::layouts.pages.main.panel')

@section('panel.head.content')
    Update Stock
@stop

@section('panel.body.content')
    {!!
        Form::open([
            'url' => route('maintenance.inventory.stocks.update', [$item->id, $stock->id]),
            'method' => 'PATCH',
            'class' => 'form-horizontal',
        ])
    !!}

    <legend class="margin-top-10">Update Stock</legend>

    <div class="form-group">
        <label class="col-sm-2 control-label">Location</label>

        <div class="col-md-4">
            @include('maintenance::select.location', [
                'location_name' => $stock->location->name,
                'location_id' => $stock->location->id
            ])
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Quantity</label>

        <div class="col-md-4">
            {!! Form::text('quantity', $stock->quantity, ['class'=>'form-control', 'placeholder'=>'ex. 45']) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Reason</label>

        <div class="col-md-4">
            {!! Form::text('reason', null, ['class'=>'form-control', 'placeholder'=>'ex. Stock Update']) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Cost</label>

        <div class="col-md-4">
            {!! Form::text('cost', null, ['class'=>'form-control', 'placeholder'=>'ex. 15.00']) !!}
        </div>
    </div>


    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {!! Form::submit('Save', ['class'=>'btn btn-primary']) !!}
        </div>
    </div>

    {!! Form::close() !!}
@stop
