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
<li class="active">
        {{ $item->name }}
</li>
@stop

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Choose a Stock Location for Item: {{ $item->name }}</h3>
    </div>
    
    <div class="panel-body">
        <a href=""
            data-target="#create-stock-modal"
            data-toggle="modal"
            class="btn btn-app">
                <i class="fa fa-plus-circle"></i> Add Stock
        </a>
        
        <hr>
        
        <div id="inventory-stocks-table">
            @if($item->stocks->count() > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Location</th>
                        <th>Quantity</th>
                        <th>Add to Work Order</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($item->stocks as $stock)
                    <tr>
                        <td>{{ $stock->location->trail }}</td>
                        <td>{{ $stock->quantity }} {{ $item->metric->name }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('maintenance.work-orders.parts.stocks.create', array($workOrder->id, $item->id, $stock->id)) }}">Add to Work Order</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <h5>There is no stock for this item.</h5>
            @endif
        </div>
    </div>
    
</div>

@include('maintenance::inventory.modals.stocks.create', array(
    ''
))

@stop