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
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Item ID</th>
                    <th>Item</th>
                    <th>Quantity Taken</th>
                    <th>Location Taken From</th>
                    <th>Date Added</th>
                    <th>Put Back</th>
                </tr>
            </thead>
            <tbody>
                @foreach($workOrder->parts as $stock)
                
                <tr>
                    <td>{{ $stock->item->id }}</td>
                    <td>{{ $stock->item->name }}</td>
                    <td>{{ $stock->pivot->quantity }}</td>
                    <td>{{ renderNode($stock->location) }}</td>
                    <td>{{ $stock->pivot->created_at }}</td>
                    <td>
                        {{ Form::open(array(
                                    'url'=>route('maintenance.work-orders.parts.stocks.destroy', array($workOrder->id, $stock->item->id, $stock->id)), 
                                    'class'=>'ajax-form-post',
                                    'data-refresh-target'=>'#content'
                                ))
                        }}

                        <button
                            type="submit" 
                            class="btn btn-primary confirm"
                            data-confirm-message="Are you sure you want to put back {{ $stock->pivot->quantity }} of {{ $stock->item->name }}?"
                            >
                            <i class="fa fa-reply"></i> Put Back
                        </button>

                        {{ Form::close() }}
                    </td>
                </tr>
                
                @endforeach
            </tbody>
        </table>
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
            
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Stock</th>
                    <th>Add</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ renderNode($item->category) }}</td>
                    <td>{{ $item->current_stock }}</td>
                    <td><a href="{{ route('maintenance.work-orders.parts.stocks.index', array($workOrder->id, $item->id)) }}" class="btn btn-primary">Add</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <center>{{ $items->appends(Input::except('page'))->links() }}</center>
        @else
        <h5>There are no inventory items to display.</h5>
        @endif
        
    </div>
</div>

@include('maintenance::inventory.modals.search', array(
    'url' => route('maintenance.work-orders.parts.index', array($workOrder->id))
))


@stop