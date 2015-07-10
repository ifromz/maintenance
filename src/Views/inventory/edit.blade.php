@extends('maintenance::layouts.pages.main.panel')

@section('title', 'Edit Item')

@section('panel.head.content')
    Edit Item
@stop

@section('panel.body.content')

        {!!
            Form::open([
                'url'=>route('maintenance.inventory.update', [$item->id]),
                'method'=>'PATCH',
                'class'=>'form-horizontal',
            ])
        !!}

        @include('maintenance::inventory.form', compact('item'))

        {!! Form::close() !!}

@stop
