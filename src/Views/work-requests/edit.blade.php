@extends('maintenance::layouts.pages.main.panel')

@section('title', 'Editing Work Request')

@section('panel.head.content')
Editing Work Request
@stop

@section('panel.body.content')

    {!!
        Form::open([
            'url' => route('maintenance.work-requests.update', [$workRequest->id]),
            'class'=>'form-horizontal',
            'method' => 'PATCH',
        ])
    !!}

    @include('maintenance::work-requests.form', compact('workRequest'))

    {!! Form::close() !!}

@stop
