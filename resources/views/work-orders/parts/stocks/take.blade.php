@extends('layouts.pages.main.panel')

@section('title', 'Take Parts')

@section('panel.head.content')
    Enter the Quantity Used
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

        <dt>Current Stock:</dt>
        <dd id="quantity-refresh">{{ $stock->quantity }}</dd>

        <p></p>
    </dl>

    <hr>

    <div class="col-md-6">
        {!! $form !!}
    </div>
@stop
