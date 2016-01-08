@extends('layouts.pages.main.panel')

@section('title', 'Return Parts')

@section('panel.head.content')
    Enter the Quantity to Return
@stop

@section('panel.body.content')
    <legend>Stock Details</legend>

    <dl class="dl-horizontal">
        <dt>Item:</dt>
        <dd>{{ $item->name }}</dd>

        <p></p>

        <dt>Location:</dt>
        <dd>{!! $stock->location->trail !!}</dd>

        <p></p>

        <dt>Quantity Used:</dt>
        <dd id="quantity-refresh">{{ $stock->pivot->quantity }}</dd>

        <p></p>
    </dl>

    <hr>

    {!! $form !!}
@stop
