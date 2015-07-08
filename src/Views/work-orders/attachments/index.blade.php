@extends('maintenance::layouts.main')

@section('title', 'Work Order Attachments')

@section('content')

    @include('maintenance::work-orders.attachments.grid.index')

@stop
