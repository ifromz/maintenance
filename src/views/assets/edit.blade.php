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
    <li class="active">
        <i class="fa fa-edit"></i>
        Edit
    </li>
@stop

@section('content')

    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Edit asset</h3>
            </div>
            <div class="panel-body">
                {{ Form::open(array('url'=>route('maintenance.assets.update', array($asset->id)), 'method'=>'PATCH', 'class'=>'form-horizontal ajax-form-post')) }}

                @include('maintenance::assets.form', compact('asset'))

                {{ Form::close() }}
            </div>
        </div>
    </div>

@stop