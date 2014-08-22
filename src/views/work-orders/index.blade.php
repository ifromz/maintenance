@extends('maintenance::layouts.main')

@section('header')
	<h1>{{ $title }}</h1>
@stop

@section('content')
	<div class="panel panel-default">
    	<div class="panel-heading">
            <div class="btn-toolbar">
                <a href="{{ route('maintenance.work-orders.create') }}" class="btn btn-primary" data-toggle="tooltip" title="Create a new Work Order">
                    <i class="fa fa-plus"></i>
                    New Work Order
                </a>
            </div>

            <div class="btn-toolbar text-center">
                {{ $workOrders->links() }}
            </div>
        </div>
        
        <div class="panel-body">
            @if($workOrders->count() > 0)
            	<table class="table table-striped">
                	<thead>
                    	<tr>
                        	<th>ID</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Created By</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="workOrder-body">
              		@foreach($workOrders as $workOrder)
              			<tr>
                        	<td>{{ $workOrder->id }}</td>
                            <td>@include('maintenance::partials.status-label', array('status'=>$workOrder->status))</td>
                            <td></td>
                            <td>{{ $workOrder->description }}</td>
                            <td>
                            	@if($workOrder->category)
                                    {{ renderNode($workOrder->category) }}
                                @endif
                         	</td>
                            <td>@include('maintenance::partials.full-name', array('user'=>$workOrder->user))</td>
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
                                            <a href="{{ route('maintenance.work-orders.destroy', array($workOrder->id)) }}" data-method="delete" data-message="Are you sure you want to delete this work order?">
                                                <i class="fa fa-trash-o"></i> Delete Work Order
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                      	</tr>
                        @endforeach
                        
                        <div class="btn-toolbar text-center">
                            {{ $workOrders->links() }}
                        </div>
                    @else
                        <h5>There are no work orders to list</h5>
                    @endif
                    </tbody>
                </table>
               
       	</div>
	</div>
@stop