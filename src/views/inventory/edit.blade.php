@extends('maintenance::layouts.main')

@section('header')
	<h1>{{ $title }}</h1>
@stop

@section('breadcrumb')

@stop

@section('content')
 <div class="col-md-12">
        
        {{ HTML::script('packages/stevebauman/maintenance/js/inventory/edit.js') }}
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Edit Item</h3>
            </div>
            <div class="panel-body">
            {{ Form::open(array(
                        'url'=>route('maintenance.inventory.update', array($item->id)), 
                        'method'=>'PATCH', 
                        'class'=>'form-horizontal', 
                        'id'=>'maintenance-inventory-edit'
                        )) 
            }}
                
                <div class="form-group">
                    <label class="col-sm-2 control-label">Category</label>
                    <div class="col-md-4">
                        @include('maintenance::select.category', array(
                            'category' => $item->category,
                            'category_id'=> $item->category->id
                        ))
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-md-4">
                        {{ Form::text('name', $item->name, array('class'=>'form-control', 'placeholder'=>'Name')) }}
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label">Description</label>
                    <div class="col-md-4">
                        {{ Form::textarea('description', $item->description, array('class'=>'form-control', 'placeholder'=>'Description')) }}
                    </div>
                </div>
                
                <div class="form-group">
                	<div class="col-sm-offset-2 col-sm-10">
                    	{{ Form::submit('Save', array('class'=>'btn btn-primary')) }}
                    </div>
                </div>
                
            {{ Form::close() }}
            </div>
        </div>
     
 </div>
@stop