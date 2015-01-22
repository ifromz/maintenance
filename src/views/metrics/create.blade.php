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
            {{
                Form::open(array(
                    'url'=>route('maintenance.metrics.store'),
                    'class'=>'form-horizontal ajax-form-post clear-form'
                ))
            }}

            @include('maintenance::metrics.form')

            {{ Form::close() }}
        </div>

    </div>

@stop