@extends('maintenance::layouts.pages.main.panel')

@section('title', 'Create Work Order')

@section('panel.head.content')
    Create a new Work Order
@stop

@section('panel.body.content')

    {!! Form::open(array('url' => route('maintenance.work-orders.store'), 'class' => 'form-horizontal clear-form')) !!}

    @include('maintenance::work-orders.form')

    {!! Form::close() !!}

@stop
