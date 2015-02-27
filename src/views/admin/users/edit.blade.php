@extends('maintenance::layouts.pages.admin.panel')

@section('panel.head.content')
    Edit User
@stop

@section('panel.body.content')
    {{
        Form::open(array(
            'url' => route('maintenance.admin.users.update', array($user->id)),
            'class' => 'form-horizontal ajax-form-post',
            'method' => 'PUT'
        ))
    }}

    @include('maintenance::admin.users.form', array(
        'user' => $user,
    ))

    {{ Form::close() }}
@stop