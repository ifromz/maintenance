@extends('maintenance::layouts.pages.main.panel')

@section('title', "Edit $resource $category->name")

@section('panel.head.content')
    Edit {{ $resource }} {{ $category->name }}
@stop

@section('panel.body.content')
{!!
    Form::open([
        'url' => route($routes['update'], [$category->id]),
        'class' => 'form-horizontal',
        'method' => 'PATCH',
    ])
!!}

@include('maintenance::categories.form', compact('category'))

{!! Form::close() !!}
@stop
