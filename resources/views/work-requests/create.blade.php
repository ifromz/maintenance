@extends('layouts.pages.main.panel')

@section('title', 'Create a Work Request')

@section('panel.head.content')
    Create a new Work Request
@stop

@section('panel.body.content')

    {!!
        Form::open([
            'url' => route('maintenance.work-requests.store'),
            'class'=>'form-horizontal'
        ])
    !!}

    @include('work-requests.form')

    {!! Form::close() !!}

@stop
