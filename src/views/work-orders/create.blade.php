@extends('maintenance::layouts.main')

@section('header')
    <h1>{{ $title }}</h1>
@stop

@section('breadcrumb')
    <li>
        <a href="{{ route('maintenance.work-orders.index') }}">
            <i class="fa fa-book"></i>
            Work Orders
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
                <h3 class="panel-title">Create a new Work Order</h3>
            </div>
            <div class="panel-body">
                {{ Form::open(array('url'=>route('maintenance.work-orders.store'), 'class'=>'form-horizontal ajax-form-post clear-form')) }}

                @include('maintenance::work-orders.form')

                {{ Form::close() }}
            </div>
        </div>
    </div>

@stop