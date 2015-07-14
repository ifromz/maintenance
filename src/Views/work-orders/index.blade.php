@extends('maintenance::layouts.main')

@section('title', 'Work Orders')

@section('content')

    @include('maintenance::work-orders.grid.index')

@stop
