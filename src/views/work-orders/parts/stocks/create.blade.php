@extends('maintenance::layouts.main')

@section('header')
	<h1>{{ $title }}</h1>
@stop

@section('breadcrumb')
<li>
    <a href="{{ route('maintenance.work-orders.index') }}">
        <i class="fa fa-book"></i> 
        Work Orders
    </a>
</li>
<li>
    <a href="{{ route('maintenance.work-orders.show', array($workOrder->id)) }}"> 
        {{ $workOrder->subject }}
    </a>
</li>
<li>
    <a href="{{ route('maintenance.work-orders.parts.index', array($workOrder->id)) }}"> 
    <i class="fa fa-wrench"></i> 
    Parts
    </a>
</li>
<li>
    <a href="{{ route('maintenance.work-orders.parts.stocks.index', array($workOrder->id, $item->id)) }}"> 
        {{ $item->name }}
    </a>
</li>
<li class="active">
    Enter Quantity
</li>
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
                    <dd>{{ $stock->location->trail }}</dd>

                    <p></p>

                    <dt>Current Stock:</dt>
                    <dd id="quantity-refresh">{{ $stock->quantity }}</dd>

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
                        <div class="input-group">
                            {{ Form::text('quantity', NULL, array('class'=>'form-control', 'placeholder'=>'ex. 45')) }}
                            <span class="input-group-addon">{{ $item->metric->symbol }}</span>
                        </div>
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