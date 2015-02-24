@extends('maintenance::layouts.pages.main.panel')

@section('header')
    <h1>{{ $title }}</h1>
@stop

@section('panel.head.content')
    <h3 class="panel-title">Choose a Stock Location for Item: {{ $item->name }}</h3>
@stop

@section('panel.body.content')

    {{ $item->viewer()->btnAddStock() }}

    <hr>

    <div id="inventory-stocks-table">

    @if($item->stocks->count() > 0)

            {{
                $item->stocks->columns(array(
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

    @else
        <h5>There is no stock for this item.</h5>
    @endif

    </div>

@stop