@extends('maintenance::layouts.main')

@section('header')
    <h1>{{ $title }}</h1>
@stop

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Update Stock</h3>
        </div>
        <div class="panel-body">

            {{
                Form::open(array(
                    'url'=>route('maintenance.inventory.stocks.update', array($item->id, $stock->id)),
                    'method'=>'PATCH',
                    'class'=>'form-horizontal ajax-form-post',
                ))
            }}
            <legend class="margin-top-10">Enter New Quantity</legend>

            <div class="form-group">
                <label class="col-sm-2 control-label">Location</label>

                <div class="col-md-4">
                    @include('maintenance::select.location', array(
                        'location_name' => $stock->location->name,
                        'location_id' => $stock->location->id
                    ))
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Quantity</label>

                <div class="col-md-4">
                    {{ Form::text('quantity', $stock->quantity, array('class'=>'form-control', 'placeholder'=>'ex. 45')) }}
                </div>
            </div>


            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    {{ Form::submit('Save', array('class'=>'btn btn-primary')) }}
                </div>
            </div>

            {{ Form::close() }}
        </div>
    </div>
@stop