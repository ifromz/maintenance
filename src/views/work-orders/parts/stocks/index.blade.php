@extends('maintenance::layouts.pages.main.panel')

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

@section('panel.head.content')
    <h3 class="panel-title">Choose a Stock Location for Item: {{ $item->name }}</h3>
@stop

@section('panel.body.content')

    {{ $item->viewer()->btnAddStock() }}

    <hr>

    @if($item->stocks->count() > 0)

        <div id="inventory-stocks-table">
            {{ $item->stocks->columns(array(
                            'location' => 'Location',
                            'quantity_metric' => 'Quantity',
                            'add' => 'Add to Work Order',
                        ))
                        ->means('location', 'location.trail')
                        ->modify('add', function($stock) use ($workOrder) {
                            return $stock->viewer()->btnAddForWorkOrder($workOrder);
                        })
                        ->render()
            }}
        </div>

    @else
        <h5>There is no stock for this item.</h5>
    @endif

@stop