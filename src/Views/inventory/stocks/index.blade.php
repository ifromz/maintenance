@extends('maintenance::layouts.main')

@section('title', 'Inventory Stocks')

@section('content')

    @include('maintenance::inventory.stocks.grid.index')

@stop
