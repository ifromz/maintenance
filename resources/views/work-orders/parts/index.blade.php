@extends('layouts.main')

@section('title', 'Work Order Parts')

@section('content')

    <h2>Parts Added</h2>

    @include('work-orders.parts.grid.index', compact('workOrder'))

    <h2>Inventory</h2>

    @include('work-orders.parts.inventory.grid.index', compact('workOrder'))

@stop
