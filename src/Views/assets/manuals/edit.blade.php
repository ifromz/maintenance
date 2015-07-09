@extends('maintenance::layouts.pages.main.panel')

@section('title', 'Edit Manual')

@section('panel.head.content')
    Edit Manual
@stop

@section('panel.body.content')

    {!!
        Form::open([
            'url' => route('maintenance.assets.manuals.update', [$asset->id, $manual->id]),
            'class' => 'form-horizontal',
            'method' => 'PATCH',
        ])
    !!}

    @include('maintenance::assets.manuals.form', compact('manual'))

    {!! Form::close() !!}

@stop
