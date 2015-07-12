@extends('maintenance::layouts.pages.main.panel')

@section('title', 'Viewing Note')

@section('panel.head.content')
Viewing Note
@stop

@section('panel.body.content')

    {!! $note->content !!}

@stop
