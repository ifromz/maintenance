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
        <i class="fa fa-dashboard"></i>
        Meters
    </li>
    <li>
        <a href="{{ route('maintenance.assets.meters.show', array($asset->id, $meter->id)) }}">
            {{ $meter->name }}
        </a>
    </li>
    <li class="active">
        <i class="fa fa-edit"></i>
        Edit
    </li>
@stop

@section('content')

    <div class="panel panel-default">

        @include('maintenance::assets.modals.meters.create')

        <div class="panel-heading">
            <h3 class="panel-title">Edit Meter</h3>
        </div>

        <div class="panel-body">
            {{ Form::open(array(
                        'url' => route('maintenance.assets.meters.update', array($asset->id, $meter->id)),
                        'method' => 'PATCH',
                        'class' => 'form-horizontal ajax-form-post'
                ))
            }}

            <div class="form-group">
                <label class="col-sm-2 control-label" for="name">Name</label>

                <div class="col-md-4">
                    {{ Form::text('name', $meter->name, array('class'=>'form-control')) }}
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label" for="name">Metric</label>

                <div class="col-md-4">
                    @include('maintenance::select.metric', array(
                        'metric' => $meter->metric->id
                    ))
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