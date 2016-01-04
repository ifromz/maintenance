@extends('layouts.main')

@section('title', 'Attach Work Orders')

@section('content')

    @include('assets.work-orders.attach.grid.index', compact('asset'))

@stop
