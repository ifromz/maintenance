@extends('maintenance::layouts.pages.main.panel')

@section('title')
    Edit Meter
@stop

@section('panel.head.content')
    Edit Meter
@stop

@section('panel.body.content')

    {!!
        Form::open([
            'url' => route('maintenance.assets.meters.update', [$asset->id, $meter->id]),
            'method' => 'PATCH',
            'class' => 'form-horizontal',
        ])
    !!}

    @include('maintenance::assets.meters.form', compact('meter'))

    {!! Form::close() !!}

@stop
