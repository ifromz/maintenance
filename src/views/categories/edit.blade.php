@extends('maintenance::layouts.main')

@section('header')
	<h1>{{ $title }}</h1>
@stop

@section('breadcrumb')
<li>
    <a href="{{ action(currentControllerAction('index')) }}">
        {{ str_plural($resource) }}
    </a>
</li>
<li class="active">
    <i class="fa fa-edit"></i>
    Edit
</li>
@stop

@section('content')
<script type="text/javascript" src="{{ asset('packages/stevebauman/maintenance/js/categories/edit.js') }}"></script>
	<div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Edit Category {{ $category->name }}</h3>
            </div>
            <div class="panel-body">
                <legend class="margin-top-10">Category Information</legend>
                {{ Form::open(array(
                        'url'=>action(currentControllerAction('update'), array($category->id)),
                        'class'=>'form-horizontal ajax-form-post',
                        'method' => 'PATCH',
                    )) 
                }}
            
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="location_name">Name</label>
                    <div class="col-md-4">
                    	{{ Form::text('name', $category->name, array('class'=>'form-control', 'placeholder'=>'ex. Electrical / Lighting')) }}
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