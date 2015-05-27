@extends('maintenance::layouts.pages.main.panel')

@section('panel.head.content')
    Edit {{ $resource }} {{ $category->name }}
@stop

@section('panel.body.content')
{!!
    Form::open([
        'url' => action(currentControllerAction('update'), [$category->id]),
        'class'=>'form-horizontal ajax-form-post',
        'method' => 'PATCH',
    )
!!}

@include('maintenance::categories.form', compact('category'))

{!! Form::close() !!}
@stop
