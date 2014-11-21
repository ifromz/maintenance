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
@stop

@section('content')
    
    @include('maintenance::work-orders.modals.search', array(
        'url'=>route('maintenance.work-orders.index')
    ))

    <div class="panel panel-default">
    	<div class="panel-heading">
            <div class="btn-toolbar">
                <a href="{{ route('maintenance.work-orders.create') }}" class="btn btn-primary" data-toggle="tooltip" title="Create a new Work Order">
                    <i class="fa fa-plus"></i>
                    New Work Order
                </a>
                <a href="#" class="btn btn-primary" data-target="#search-modal" data-toggle="modal" title="Filter results">
                    <i class="fa fa-search"></i>
                    Search
                </a>
            </div>
        </div>
        
        <div id="resource-paginate" class="panel-body">
            
            @if($workOrders->count() > 0)
            
                @include('maintenance::work-orders.table', array(
                    'workOrders'=>$workOrders
                ))
                
            @else
            
                <h5>There are no work orders to display.</h5>
                
            @endif
            
            <div class="text-center">{{ $workOrders->appends(Input::except('page'))->links() }}</div>
            
        </div>
        
    </div>
    
@stop