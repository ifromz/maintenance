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
                <a href="#" class="btn btn-primary" data-target="#search-modal" data-toggle="modal" title="Filter results">
                    <i class="fa fa-search"></i>
                    Search
                </a>
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
                            <th>Subject</th>
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
                            <td>
                                @if($workOrder->priority) 
                                    {{ trans(sprintf('maintenance::priorities.%s', $workOrder->priority)) }}
                                @else
                                    <em>None Set</em>
                                @endif
                            </td>
                            <td>{{ $workOrder->subject }}</td>
                            <td>{{ str_limit($workOrder->description) }}</td>
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
                            {{ $workOrders->appends(Input::except('page'))->links() }}
                        </div>
                    @else
                        <h5>There are no work orders to list</h5>
                    @endif
                </tbody>
            </table>
               
        </div>
    </div>

<div class="modal fade" id="search-modal" tabindex="-1 "role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(array('url'=>route('maintenance.work-orders.index'), 'method'=>'GET', 'class'=>'form-horizontal')) }}
            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Filter Your Work Order Results</h4>
            </div>
            <div class="modal-body">
                
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Subject</label>
                        <div class="col-md-10">
                            {{ Form::text(
                                        'subject', 
                                        (Input::has('subject') ? Input::get('subject') : NULL),  
                                        array('class'=>'form-control', 'placeholder'=>'Enter Subject')
                                    ) 
                            }}
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Description</label>
                        <div class="col-md-10">
                            {{ Form::text(
                                        'description', 
                                        (Input::has('description') ? Input::get('description') : NULL),  
                                        array('class'=>'form-control', 'placeholder'=>'Enter Description')
                                    ) 
                            }}
                        </div>
                    </div>
                
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Priority</label>
                        <div class="col-md-10">
                            {{ Form::select(
                                        'priority', 
                                        trans('maintenance::priorities'), 
                                        (Input::has('priority') ? Input::get('priority') : NULL), 
                                        array('class'=>'form-control select2', 'placeholder'=>'ex. Low / Lowest')
                                    ) 
                            }}
                        </div>
                    </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
        
        {{ Form::close() }}
    </div>
</div>
@stop