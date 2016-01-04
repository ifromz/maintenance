@extends('layouts.main')

@section('title', 'Select a Stock')

@section('content')

    <h2>Stocks</h2>

    @include('work-orders.parts.inventory.stocks.grid.index', compact('item', 'workOrder'))

    <h2>Item Variants</h2>

    @include('work-orders.parts.inventory.variants.grid.index', compact('item', 'workOrder'))

@stop
