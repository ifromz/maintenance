@extends('maintenance::layouts.pages.main.panel')

@section('panel.head.content')
    Edit Item
@stop

@section('panel.body.content')

        @include('maintenance::metrics.modals.create')

        {!!
            Form::open([
                'url'=>route('maintenance.inventory.update', [$item->id]),
                'method'=>'PATCH',
                'class'=>'form-horizontal ajax-form-post',
            ])
        !!}

        @include('maintenance::inventory.form', compact('item'))

        {!! Form::close() !!}
@stop
