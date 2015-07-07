@extends('maintenance::layouts.main')

@section('title', 'Work Order Sessions')

@section('content')

    @include('maintenance::work-orders.sessions.grid.index', compact('workOrder'))

@stop
