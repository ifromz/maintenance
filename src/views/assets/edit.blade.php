@extends('maintenance::layouts.pages.main.panel')

@section('title', 'Edit Asset')

@section('panel.head.content')
    Edit Asset
@stop

@section('panel.body.content')
{!!
    Form::open([
        'url' => route('maintenance.assets.update', [$asset->id]),
        'method' => 'PATCH',
        'class' => 'form-horizontal'
    ])
!!}

    @include('maintenance::assets.form', compact('asset'))

{!! Form::close() !!}
@stop
