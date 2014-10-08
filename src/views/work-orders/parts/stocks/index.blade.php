@extends('maintenance::layouts.main')

@section('header')
	<h1>{{ $title }}</h1>
@stop

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Enter Quantity Used for each Stock Location</h3>
    </div>
    
    <div class="panel-body">
        <a href=""
            data-target="#create-stock-modal"
            data-toggle="modal"
            class="btn btn-app">
                <i class="fa fa-plus-circle"></i> Add Stock
        </a>
        
        <hr>
        
        {{ HTML::script('public/packages/stevebauman/maintenance/js/work-orders/parts/create.js') }}
       
        
        <div id="inventory-stocks-table">
            @if($item->stocks->count() > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Location</th>
                        <th>Quantity</th>
                        <th>Add</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($item->stocks as $stock)
                    <tr>
                        <td>{{ renderNode($stock->location) }}</td>
                        <td>{{ $stock->quantity }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('maintenance.work-orders.parts.stocks.add', array($workOrder->id, $item->id, $stock->id)) }}">Add</a>
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