@extends('maintenance::layouts.main')

@section('header')
    <h1>{{ $title }}</h1>
@stop

@section('breadcrumb')
<li>
    <a href="{{ route('maintenance.assets.index') }}">
        <i class="fa fa-truck"></i> 
        Assets
    </a>
</li>
<li>
    <a href="{{ route('maintenance.assets.show', array($asset->id)) }}">
        {{ $asset->name }}
    </a>
</li>
<li>
    <i class="fa fa-calendar"></i>
    Calendars
</li>
<li class="active">
    <i class="fa fa-plus-circle"></i>
    Create
</li>
@stop

@section('content')

<div class="panel panel-default">
    
    <div class="panel-heading">
        <h3 class="panel-title">Create Calendar</h3>
    </div>
    
    <div class="panel-body">
        
        {{ Form::open(array(
                    'url'=>route('maintenance.assets.calendars.store', array($asset->id)), 
                    'class'=>'form-horizontal ajax-form-post clear-form')
                ) 
        }}
        
        <legend class="margin-top-10">Required Information</legend>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="name">Name</label>
            <div class="col-md-4">
                {{ Form::text('name', NULL, array('class'=>'form-control', 'placeholder'=>'ex. Maintenance Schedule')) }}
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-2 control-label" for="name">Description</label>
            <div class="col-md-4">
                {{ Form::textarea('description', NULL, array('class'=>'form-control')) }}
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-md-4 col-md-offset-2">
                {{ Form::submit('Save', array('class'=>'btn btn-primary')) }}
            </div>
        </div>
        
        {{ Form::close() }}
        
    </div>
    
</div>

@stop