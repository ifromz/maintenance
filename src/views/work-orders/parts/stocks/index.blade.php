@extends('maintenance::layouts.pages.main.panel')

@section('panel.head.content')
    <h3 class="panel-title">Choose a Stock Location for Item: {{ $item->name }}</h3>
@stop

@section('panel.body.content')

    {!! $item->viewer()->btnAddStock() !!}

    <h2>Stocks</h2>

    <div id="inventory-stocks-table">

    @if($item->stocks->count() > 0)

            {!!
                $item->stocks
                    ->columns([
                        'location' => 'Location',
                        'quantity_metric' => 'Quantity',
                        'add' => 'Add to Work Order',
                    ])
                    ->means('location', 'location.trail')
                    ->modify('add', function($stock) use ($workOrder) {
                        return $stock->viewer()->btnAddForWorkOrder($workOrder);
                    })
                    ->render()
            !!}

    @else
        <h5>There is no stock for this item.</h5>
    @endif

    </div>

    <h2>Variants</h2>


    @if($item->variants->count() > 0)

        {!!
            $item->variants
                ->columns([
                    'id' => 'ID',
                    'name' => 'Name',
                    'category' => 'Category',
                    'current_stock' => 'Current Stock',
                    'description' => 'Description',
                    'created_at' => 'Added On',
                    'select' => 'Select',
                ])
                ->means('category', 'category.trail')
                ->modify('current_stock', function($item) {
                    return $item->viewer()->lblCurrentStock();
                })
                ->modify('select', function($item) use ($workOrder) {
                    return $item->viewer()->btnSelectForWorkOrder($workOrder);
                })
                ->render()
        !!}

    @else
        <h5>There are no variants for this item.</h5>
    @endif

@stop
