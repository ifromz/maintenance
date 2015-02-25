@extends('maintenance::layouts.pages.main.panel')

@section('panel.head.content')
    Create Work Request
@stop

@section('panel.body.content')
    {{
        Form::open(array(
            'url'=>route('maintenance.work-orders.requests.store', array($workRequest->id)),
            'class'=>'form-horizontal ajax-form-post clear-form',
            'method' => 'PUT'
        ))
    }}

    @include('maintenance::work-orders.requests.form', array(
        'workRequest' => $workRequest,
    ))

    {{ Form::close() }}
@stop