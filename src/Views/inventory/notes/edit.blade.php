@extends('maintenance::layouts.pages.main.panel')

@section('title', 'Edit Note')

@section('panel.head.content')
    Edit Note
@stop

@section('panel.body.content')

    {!!
        Form::open([
            'url' => route('maintenance.inventory.notes.update', [$item->id, $note->id]),
            'method' => 'PATCH',
            'class' => 'form-horizontal'
        ])
    !!}

    @include('maintenance::inventory.notes.form', compact('note'))

    {!! Form::close() !!}

@stop
