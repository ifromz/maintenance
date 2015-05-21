@extends('maintenance::layouts.pages.main.panel')

@section('panel.head.content')
    Create Item Variant
@stop

@section('panel.body.content')

    @include('maintenance::metrics.modals.create')

    {{
        Form::open([
            'url'=>route('maintenance.inventory.variants.store', [$item->id]),
            'class'=>'form-horizontal ajax-form-post',
        ])
    }}

    @include('maintenance::inventory.form', compact('item'))

    {{ Form::close() }}
@stop