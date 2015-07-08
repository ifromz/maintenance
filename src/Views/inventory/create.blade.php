@extends('maintenance::layouts.pages.main.panel')

@section('title', 'Create Item')

@section('panel.head.content')
    Add an Item
@stop

@section('panel.body.content')
    @include('maintenance::metrics.modals.create')

    {!!
        Form::open([
            'url' => route('maintenance.inventory.store'),
            'class' => 'form-horizontal'
        ])
    !!}

    @include('maintenance::inventory.form')

    {!! Form::close() !!}
@stop
