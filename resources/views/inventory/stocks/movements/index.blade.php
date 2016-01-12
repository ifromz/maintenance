@extends('layouts.master')

@section('title', 'Stock Movements')

@section('content')

    @include('inventory.stocks.movements.grid.index', compact('item', 'stock'))

@endsection
