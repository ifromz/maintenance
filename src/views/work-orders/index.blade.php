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
                <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>{{ link_to_sort('maintenance.work-orders.index', 'ID', array('field'=>'id', 'sort'=>'asc')) }}</th>
                            <th>{{ link_to_sort('maintenance.work-orders.index', 'Status', array('field'=>'status', 'sort'=>'asc')) }}</th>
                            <th>{{ link_to_sort('maintenance.work-orders.index', 'Priority', array('field'=>'priority', 'sort'=>'asc')) }}</th>
                            <th>{{ link_to_sort('maintenance.work-orders.index', 'Subject', array('field'=>'subject', 'sort'=>'asc')) }}</th>
                            <th>{{ link_to_sort('maintenance.work-orders.index', 'Description', array('field'=>'description', 'sort'=>'asc')) }}</th>
                            <th>{{ link_to_sort('maintenance.work-orders.index', 'Category', array('field'=>'category_id', 'sort'=>'asc')) }}</th>
                            <th>{{ link_to_sort('maintenance.work-orders.index', 'Created By', array('field'=>'user', 'sort'=>'asc')) }}</th>
                            <th>{{ link_to_sort('maintenance.work-orders.index', 'Created At', array('field'=>'created_at', 'sort'=>'asc')) }}</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="workOrder-body">
                        @foreach($workOrders as $workOrder)
                        <tr>
                            <td>{{ $workOrder->id }}</td>
                            <td>{{ $workOrder->status->label }}</td>
                            <td>
                                {{ $workOrder->priority->label }}
                            </td>
                            <td>{{ $workOrder->subject }}</td>
                            <td>{{ str_limit($workOrder->description) }}</td>
                            <td>
                                {{ renderNode($workOrder->category) }}
                            </td>
                            <td>{{ $workOrder->user->full_name }}</td>
                            <td>{{ $workOrder->created_at }}</td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                                        Action
                                        <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{{ route('maintenance.work-orders.show', array($workOrder->id)) }}">
                                                <i class="fa fa-search"></i> View Work Order
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('maintenance.work-orders.edit', array($workOrder->id)) }}">
                                                <i class="fa fa-edit"></i> Edit Work Order
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('maintenance.work-orders.destroy', array($workOrder->id)) }}" data-method="delete" data-message="Are you sure you want to delete this work order? It will be archived.">
                                                <i class="fa fa-trash-o"></i> Delete Work Order
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <h5>There are no work orders to display.</h5>
            @endif

            <div class="text-center">{{ $workOrders->appends(Input::except('page'))->links() }}</div>
        </div>
    </div>
@stop