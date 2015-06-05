@extends('maintenance::layouts.pages.main.panel')

@section('title', 'Edit Work Order')

@section('panel.head.content')
    Edit Work Order
@stop

@section('panel.body.content')

    {!!
        Form::open([
            'url'=>route('maintenance.work-orders.update', [$workOrder->id]),
            'class'=>'form-horizontal',
            'method'=>'PATCH'
        ])
    !!}

    @include('maintenance::work-orders.form', compact('workOrder'))

    {!! Form::close() !!}

@stop
