@extends('layouts.pages.main.panel')

@section('title')
Create Meter
@stop

@section('panel.head.content')
    Create a Meter
@stop

@section('panel.body.content')

    {!!
        Form::open([
            'url' => route('maintenance.assets.meters.store', [$asset->id]),
            'class' => 'form-horizontal',
        ])
    !!}

    @include('assets.meters.form')

    {!! Form::close() !!}

@stop
