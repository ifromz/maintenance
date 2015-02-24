@extends('maintenance::layouts.pages.main.panel')

@section('panel.head.content')
    Edit Work Order
@stop

@section('panel.body.content')

{{
    Form::open(array(
        'url'=>route('maintenance.work-orders.update', array($workOrder->id)),
        'class'=>'form-horizontal ajax-form-post',
        'method'=>'PATCH'
    ))
}}

    @include('maintenance::work-orders.form', compact('workOrder'))

{{ Form::close() }}

@stop