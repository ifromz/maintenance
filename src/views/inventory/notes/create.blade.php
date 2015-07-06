@extends('maintenance::layouts.pages.main.panel')

@section('title', 'Create Note')

@section('panel.head.content')
Create Note
@stop

@section('panel.body.content')
    {!!
        Form::open([
            'url' => route('maintenance.inventory.notes.store', [$item->id]),
            'class' => 'form-horizontal'
        ])
    !!}

    @include('maintenance::inventory.notes.form')

    {!! Form::close() !!}
@stop
