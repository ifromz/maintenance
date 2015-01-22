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
    <li class="active">
        <i class="fa fa-plus-circle"></i>
        Create
    </li>
@stop

@section('content')

    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Create a new Asset</h3>
            </div>
            <div class="panel-body">
                {{ Form::open(array('url'=>route('maintenance.assets.store'), 'class'=>'form-horizontal ajax-form-post clear-form')) }}

                @include('maintenance::assets.form')

                {{ Form::close() }}
            </div>
        </div>
    </div>

@stop