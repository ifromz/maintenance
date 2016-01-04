@extends('layouts.main')

@section('title', 'Work Order Sessions')

@section('content')

    @include('work-orders.sessions.grid.index', compact('workOrder'))

@stop
