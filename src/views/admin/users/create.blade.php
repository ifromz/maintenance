@extends('maintenance::layouts.pages.admin.panel')

@section('panel.head.content')
    Create User
@stop

@section('panel.body.content')
    {{
        Form::open(array(
            'url' => route('maintenance.admin.users.store'),
            'class' => 'form-horizontal ajax-form-post clear-form'
        ))
    }}

    @include('maintenance::admin.users.form')

    {{ Form::close() }}
@stop