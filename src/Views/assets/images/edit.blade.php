@extends('maintenance::layouts.pages.main.panel')

@section('title', 'Edit Image')

@section('panel.head.content')
    Edit Image
@stop

@section('panel.body.content')

    {!!
        Form::open([
            'url' => route('maintenance.assets.images.update', [$asset->id, $image->id]),
            'class' => 'form-horizontal',
            'method' => 'PATCH',
        ])
    !!}

    @include('maintenance::assets.images.form', compact('image'))

    {!! Form::close() !!}

@stop
