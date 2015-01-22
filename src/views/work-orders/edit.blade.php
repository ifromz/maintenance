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
    <li>
        <a href="{{ route('maintenance.work-orders.show', array($workOrder->id)) }}">
            {{ $workOrder->subject }}
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
                <h3 class="panel-title">Edit Work Order</h3>
            </div>
            <div class="panel-body">
                {{ Form::open(array(
                            'url'=>route('maintenance.work-orders.update', array($workOrder->id)),
                            'class'=>'form-horizontal ajax-form-post',
                            'method'=>'PATCH'
                        ))
                }}

                @include('maintenance::work-orders.form', compact('workOrder'))

                {{ Form::close() }}
            </div>
        </div>
    </div>

@stop