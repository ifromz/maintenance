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
    <li>
        {{ $metric->name }}
    </li>
    <li class="active">
        <i class="fa fa-edit"></i>
        Edit
    </li>
@stop

@section('content')

    <div class="panel panel-default">

        <div class="panel-heading">
            <h3 class="panel-title">Edit Metric</h3>
        </div>

        <div class="panel-body">
            {{
                Form::open(array(
                    'url'=>route('maintenance.metrics.update', array($metric->id)),
                    'method'=>'PATCH',
                    'class'=>'form-horizontal ajax-form-post'
                ))
            }}

            @include('maintenance::metrics.form', compact('metric'))

            {{ Form::close() }}
        </div>

    </div>

@stop