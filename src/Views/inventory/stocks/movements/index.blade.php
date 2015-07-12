@extends('maintenance::layouts.main')

@section('title', 'Stock Movements')

@section('content')

    @include('maintenance::inventory.stocks.movements.grid.index', compact('item', 'stock'))

@stop
