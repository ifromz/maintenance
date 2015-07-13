@extends('maintenance::layouts.pages.main.panel')

@section('title', 'Update Stock')

@section('panel.head.content')
    Update Stock
@stop

@section('panel.body.content')

    {!!
        Form::open([
            'url' => route('maintenance.inventory.stocks.update', [$item->id, $stock->id]),
            'method' => 'PATCH',
            'class' => 'form-horizontal',
        ])
    !!}

    @include('maintenance::inventory.stocks.form', compact('item', 'stock'))

    {!! Form::close() !!}

@stop
