@extends('maintenance::layouts.main')

@section('title', 'Attach Work Orders')

@section('content')

    @include('maintenance::assets.work-orders.attach.grid.index', compact('asset'))

@stop
