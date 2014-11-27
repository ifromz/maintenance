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
        <i class="fa fa-book"></i> 
        {{ $workOrder->subject }}
    </a>
</li>
<li class="active">
    <i class="fa fa-wrench"></i> 
    Parts
</li>
@stop

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Parts Added</h3>
    </div>
    <div class="panel-body">
        @if($workOrder->parts->count() > 0)
        
            {{ $workOrder->parts
                    ->columns(array(
                        'item_id' => 'Item ID',
                        'item' => 'Item',
                        'quantity_taken' => 'Quantity Taken',
                        'taken_from' => 'Taken From',
                        'date_added' => 'Date Added',
                        'put_back' => 'Put Back'
                     ))
                     ->means('item_id', 'item.id')
                     ->means('item', 'item.name')
                     ->means('quantity_taken', 'pivot.quantity')
                     ->means('taken_from', 'location.trail')
                     ->means('date_added', 'pivot.created_at')
                     ->modify('put_back', function($stock) use($workOrder) {
                         return $stock->viewer()->btnActionsForWorkOrder($workOrder);
                     })
                     ->render()
            }}
            
        @else
        
        <h5>There are currently no parts/supplies attached to this work order.</h5>
        
        @endif
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="btn-toolbar">
            <a href="#" class="btn btn-primary" data-target="#search-modal" data-toggle="modal" title="Filter results">
                <i class="fa fa-search"></i>
                Search
            </a>
        </div>
    </div>
    <div id="resource-paginate" class="panel-body">
        
        <legend>Inventory</legend>
        
        @if($items->count() > 0)
            
            {{ $items->columns(array(
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
        
    </div>
</div>

@include('maintenance::inventory.modals.search', array(
    'url' => route('maintenance.work-orders.parts.index', array($workOrder->id))
))


@stop