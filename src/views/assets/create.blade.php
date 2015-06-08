@extends('maintenance::layouts.pages.main.panel')

@section('title', 'Create an Asset')

@section('panel.head.content')
    Create a new Asset
@stop

@section('panel.body.content')
{!!
    Form::open([
        'url' => route('maintenance.assets.store'),
        'class' => 'form-horizontal ajax-form-post clear-form'
    ])
!!}

    @include('maintenance::assets.form')

{!! Form::close() !!}
@stop
