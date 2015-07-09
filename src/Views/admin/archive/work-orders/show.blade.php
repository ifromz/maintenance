@extends('maintenance::layouts.pages.admin.panel')

@section('title', 'Viewing Archived Work Orders')

@section('panel.head.content')
    Viewing Work Order
@stop

@section('panel.body.content')

    {!! $workOrder->viewer()->btnRestore() !!}

    {!! $workOrder->viewer()->btnDeleteArchive() !!}

    <hr>

    {!! $workOrder->viewer()->profile() !!}

@stop
