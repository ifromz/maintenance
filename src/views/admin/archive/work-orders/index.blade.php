@extends('maintenance::layouts.admin')

@section('title', 'Archived Work Order')

@section('content')

    @include('maintenance::admin.archive.work-orders.grid.index')

@stop
