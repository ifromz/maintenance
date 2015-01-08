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
    <li>
        {{ $category->name }}
    </li>
    <li class="active">
        <i class="fa fa-plus-circle"></i>
        Create Sub-{{ $resource }}
    </li>
@stop

@section('content')
    <script type="text/javascript"
            src="{{ asset('packages/stevebauman/maintenance/js/categories/create.js') }}"></script>
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Create a new Sub-{{ $resource }} for {{ $category->name }}</h3>
            </div>
            <div class="panel-body">

                {{ Form::open(array(
                        'url'=>action(currentControllerAction('store'), array($category->id)), 
                        'class'=>'form-horizontal ajax-form-post clear-form'
                    )) 
                }}

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="location_name">Name</label>

                    <div class="col-md-4">
                        {{ Form::text('name', NULL, array('class'=>'form-control', 'placeholder'=>'ex. Electrical / Lighting')) }}
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