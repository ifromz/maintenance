@extends('maintenance::layouts.pages.main.panel')

@section('panel.head.content')
    <div class="btn-toolbar">
        <a href="{{ route('maintenance.work-orders.attachments.create', [$workOrder->id]) }}"
           class="btn btn-primary" data-toggle="tooltip" title="Upload Work Order Attachments">
            <i class="fa fa-plus"></i>
            Upload Attachments
        </a>
    </div>
@stop

@section('panel.body.content')

    {{ $workOrder->viewer()->attachments() }}

@stop
