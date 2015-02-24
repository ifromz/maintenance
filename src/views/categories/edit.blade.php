@extends('maintenance::layouts.pages.main.panel')

@section('panel.head.content')
    Edit {{ $resource }} {{ $category->name }}
@stop

@section('panel.body.content')
{{
    Form::open(array(
        'url'=>action(currentControllerAction('update'), array($category->id)),
        'class'=>'form-horizontal ajax-form-post',
        'method' => 'PATCH',
    ))
}}

@include('maintenance::categories.form', compact('category'))

{{ Form::close() }}
@stop