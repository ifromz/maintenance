@extends('maintenance::layouts.main')

@section('header')
	<h1>{{ $title }}</h1>
@stop

@section('content')

<div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Enter The Quantity Used</h3>
            </div>
            <div class="panel-body">
                <legend>Details</legend>
                

                <dl class="dl-horizontal">
                    <dt>Item:</dt>
                    <dd>{{ $item->name }}</dd>

                    <p></p>

                    <dt>Location:</dt>
                    <dd>{{ renderNode($stock->location) }}</dd>

                    <p></p>

                    <dt>Quanty In this Location:</dt>
                    <dd id="quantity-refresh">{{ renderNode($stock->quantity) }}</dd>

                    <p></p>
                </dl>

                <hr>
                
                {{ Form::open(array(
                            'url'=>route('maintenance.work-orders.parts.stocks.store', array($workOrder->id, $item->id, $stock->id)), 
                            'class'=>'form-horizontal ajax-form-post clear-form',
                            'data-refresh-target'=>'#quantity-refresh'
                        ))
                }}
                <div class="form-group">
                    <label class="col-sm-2 control-label">Quantity Taken</label>
                    <div class="col-md-4">
                        {{ Form::text('quantity', NULL, array('class'=>'form-control', 'placeholder'=>'0.00')) }}
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
    
</div>
@stop