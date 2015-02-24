@extends('maintenance::layouts.main')

@section('header')
    <h1>{{ $title }}</h1>
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