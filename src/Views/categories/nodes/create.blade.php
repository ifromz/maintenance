@extends('maintenance::layouts.pages.main.panel')

@section('panel.head.content')
    Create a new Sub-{{ $resource }} for {{ $category->name }}
@stop

@section('panel.body.content')
    {!!
        Form::open([
            'url'=> route($routes['create-node'], [$category->id]),
            'class'=>'form-horizontal clear-form'
        ])
    !!}

    @include('maintenance::categories.form', ['category' => $category])

    {!! Form::close() !!}
@stop
