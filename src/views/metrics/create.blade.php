@extends('maintenance::layouts.main')

@section('header')
	<h1>{{ $title }}</h1>
@stop

@section('breadcrumb')
<li>
    <a href="{{ route('maintenance.metrics.index') }}">
        <i class="fa fa-anchor"></i> 
        Metrics
    </a>
</li>
<li class="active">
    <i class="fa fa-plus-circle"></i>
    Create
</li>
@stop

@section('content')

<div class="panel panel-default">
    
    <div class="panel-heading">
        <h3 class="panel-title">Create a new Metric</h3>
    </div>
    
    <div class="panel-body">
        {{ Form::open(array('url'=>route('maintenance.metrics.store'), 'class'=>'form-horizontal ajax-form-post clear-form')) }}

        <div class="form-group">
            <label class="col-sm-2 control-label">Name</label>
            <div class="col-md-4">
                {{ Form::text('name', NULL, array('class'=>'form-control', 'placeholder'=>'ex. LB, Tonne, Litre, ML')) }}
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-2 control-label">Symbol</label>
            <div class="col-md-4">
                {{ Form::text('symbol', NULL, array('class'=>'form-control', 'placeholder'=>'Kms')) }}
            </div>
        </div>
                
        <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                {{ Form::submit('Save', array('class'=>'btn btn-primary')) }}
            </div>
        </div>
    </div>
    
</div>

@stop