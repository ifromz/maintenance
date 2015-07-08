@extends('maintenance::layouts.pages.main.panel')

@section('title', "Edit Status: $status->name")

@section('panel.head.content')
    Edit Status
@stop

@section('panel.body.content')

    {!!
        Form::open([
            'url' => route('maintenance.work-orders.statuses.update', [$status->id]),
            'method' => 'PATCH',
            'class' => 'form-horizontal'
        ])
    !!}

    @include('maintenance::work-orders.statuses.form', compact('status'))

    {!! Form::close() !!}

@stop
