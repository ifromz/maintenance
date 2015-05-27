@extends('maintenance::layouts.pages.main.panel')

@section('panel.head.content')
    Edit asset
@stop

@section('panel.body.content')
{!!
    Form::open([
        'url' => route('maintenance.assets.update', [$asset->id]),
        'method' => 'PATCH',
        'class' => 'form-horizontal ajax-form-post'
    ])
!!}

    @include('maintenance::assets.form', compact('asset'))

{!! Form::close() !!}
@stop
