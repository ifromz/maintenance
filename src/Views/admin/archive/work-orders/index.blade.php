@extends('maintenance::layouts.admin')

@section('title', 'Archived Work Orders')

@section('content')

    @include('maintenance::admin.archive.work-orders.grid.index')

@stop
