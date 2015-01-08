@extends('maintenance::layouts.admin')

@section('header')
    <h1>{{ $title }}</h1>
@stop

@section('breadcrumb')
    <li>
        <a href="{{ route('maintenance.admin.archive.index') }}">
            <i class="fa fa-archive"></i>
            Archive
        </a>
    </li>
    <li>
        <a href="{{ route('maintenance.admin.archive.work-orders.index') }}">
            <i class="fa fa-wrench"></i>
            Work Orders
        </a>
    </li>
    <li class="active">
        {{ $workOrder->subject }}
    </li>
@stop

@section('content')

    <div class="panel panel-default">

        <div class="panel-heading">
            <h3 class="panel-title">Limited View While viewing in Archive</h3>
        </div>

        <div class="panel-body">

            <a href="{{ route('maintenance.admin.archive.work-orders.restore', array($workOrder->id)) }}"
               data-method="post"
               data-title="Restore Work Order?"
               data-message="Are you sure you want to restore this work order?"
               class="btn btn-app">
                <i class="fa fa-refresh"></i> Restore
            </a>

            <a href="{{ route('maintenance.admin.archive.work-orders.destroy', array($workOrder->id)) }}"
               data-method="delete"
               data-title="Delete asset?"
               data-message="Are you sure you want to delete this work order? All data for this work order will be lost, and won't be recoverable."
               class="btn btn-app">
                <i class="fa fa-trash-o"></i> Delete (Permanent)
            </a>

            <hr>

            @include('maintenance::work-orders.tabs.profile.description', array(
                'workOrder'=>$workOrder
            ))

            <legend>More Information:</legend>

            <dl class="dl-horizontal">

                <dt>Attachments:</dt>
                <dd>{{ $workOrder->attachments->count() }}</dd>

                <p></p>

                <dt>Workers Assigned:</dt>
                <dd>
                    @if($workOrder->assignments->count() > 0)
                        @foreach($workOrder->assignments as $assignment)
                            <span class="label label-default">{{ $assignment->to_user->full_name }}</span>
                        @endforeach
                    @else
                        0
                    @endif
                </dd>

                <p></p>


            </dl>
        </div>

    </div>

@stop