@extends('maintenance::layouts.main')

@section('title', 'Work Order Sessions')

@section('content')
    <h2>Sessions</h2>

    @include('maintenance::work-orders.sessions.grid.index', compact('workOrder'))
@stop
