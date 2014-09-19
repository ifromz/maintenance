@extends('maintenance::layouts.main')

@section('header')
	<h1>{{ $title }}</h1>
@stop

@section('breadcrumb')

@stop

@section('content')
	<div class="panel panel-default">
    	<div class="panel-heading">
            <div class="btn-toolbar">
                <a href="{{ route('maintenance.inventory.create') }}" class="btn btn-primary" data-toggle="tooltip" title="Add new Item to inventory">
                    <i class="fa fa-plus"></i>
                    New Item
                </a>
                <a href="#" class="btn btn-primary" data-target="#search-modal" data-toggle="modal" title="Filter results">
                    <i class="fa fa-search"></i>
                    Search
                </a>
            </div>
        </div>
        
            <div class="panel-body">
                @if($items->count() > 0)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Current Stock</th>
                            <th>Description</th>
                            <th>Added</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->currentStock }}</td>
                            <td>{{ $item->description_short }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>
                            <div class="btn-group">
                                <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                                    Action
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('maintenance.inventory.show', array($item->id)) }}">
                                            <i class="fa fa-search"></i> View Item
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('maintenance.inventory.edit', array($item->id)) }}">
                                            <i class="fa fa-edit"></i> Edit Item
                                        </a>
                                    </li>
                                    <li>
                                        <a 
                                            href="{{ route('maintenance.inventory.destroy', array($item->id)) }}" 
                                            data-method="delete" 
                                            data-message="Are you sure you want to delete this item?">
                                            <i class="fa fa-trash-o"></i> Delete Item
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                        </tr>
                        @endforeach
                        
                        <div class="btn-toolbar text-center">
                            {{ $items->appends(Input::except('page'))->links() }}
                        </div>
                    </tbody>
                </table>
                @else
                <h5>There are no inventory items to list.</h5>
                @endif
            </div>
        </div>

<div class="modal fade" id="search-modal" tabindex="-1 "role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {{ Form::open(array('url'=>route('maintenance.inventory.index'), 'method'=>'GET', 'class'=>'form-horizontal')) }}
            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Filter Your Work Order Results</h4>
            </div>
            <div class="modal-body">
                
                <div class="form-group">
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-md-10">
                        {{ Form::text(
                                    'name', 
                                    (Input::has('name') ? Input::get('name') : NULL),  
                                    array('class'=>'form-control', 'placeholder'=>'Enter Name')
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
                    <label class="col-sm-2 control-label">Stock Level</label>
                    <div class="col-md-6">
                        {{ Form::select('operator', array(
                            '>' => 'Greater Than', 
                            '<' => 'Less Than', 
                            '=' => 'Equals', 
                            '>=' => 'Greater Than or Equal To', 
                            '<=' => 'Less Than or Equal To',
                        ), (Input::has('operator') ? Input::get('operator') : NULL), array('class'=>'form-control')) }}
                    </div>
                    <div class="col-md-4">
                        {{ Form::text('quantity', (Input::has('quantity') ? Input::get('quantity') : NULL), array('class'=>'form-control', 'placeholder'=>'Enter Quantity')) }}
                    </div>
                </div>
                
                
                <div class="form-group">
                    <label class="col-sm-2 control-label">Category</label>
                    <div class="col-md-10">
                        @include('maintenance::select.location', array(
                            'location_name' => (Input::has('location_name') ? Input::get('location_name') : NULL),
                            'location_id' => (Input::has('location_id') ? Input::get('location_id') : NULL)
                        ))
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-search-plus"></i> Search</button>
            </div>
        </div>
        
        {{ Form::close() }}
    </div>
</div>
@stop