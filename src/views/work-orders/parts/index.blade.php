@extends('maintenance::layouts.pages.main.panel')

@section('panel.head.content')
    Add Parts to Work Order
@stop

@section('panel.body.content')
    <legend>Parts Added</legend>

    @if($workOrder->parts->count() > 0)
        {{ $workOrder->viewer()->parts }}
    @else
        <h5>There are currently no parts/supplies attached to this work order.</h5>
    @endif

    <hr>

    <div class="btn-toolbar">
        <a href="#" class="btn btn-primary" data-target="#search-modal" data-toggle="modal"
           title="Filter results">
            <i class="fa fa-search"></i>
            Search Inventory
        </a>
    </div>

    <hr>

    <legend>Inventory</legend>

    @if($items->count() > 0)

        {{
            $items->columns(array(
                'id' => 'ID',
                'name' => 'Name',
                'category' => 'Category',
                'current_stock' => 'Current Stock',
                'select' => 'Select',
            ))
            ->means('category', 'category.trail')
            ->modify('select', function($item) use ($workOrder) {
                return $item->viewer()->btnSelectForWorkOrder($workOrder);
            })
            ->showPages()
            ->render()
        }}

    @else
        <h5>There are no inventory items to display.</h5>
    @endif

    @include('maintenance::inventory.modals.search', array(
        'url' => route('maintenance.work-orders.parts.index', array($workOrder->id))
    ))
@stop
