@extends('maintenance::layouts.pages.main.panel')

@section('header')
    <h1>{{ $title }}</h1>
@stop

@section('breadcrumb')
    <li>
        <a href="{{ route('maintenance.work-orders.index') }}">
            <i class="fa fa-book"></i>
            Work Orders
        </a>
    </li>
    <li class="active">
        <i class="fa fa-info-circle"></i>
        Statuses
    </li>
@stop

@section('panel.head.content')
    <div class="btn-toolbar">
        <a href="{{ route('maintenance.work-orders.statuses.create') }}" class="btn btn-primary" data-toggle="tooltip"
           title="Create a new Status">
            <i class="fa fa-plus"></i>
            New Status
        </a>
    </div>
@stop

@section('panel.body.content')

    @if($statuses->count() > 0)

        {{ $statuses->columns(array(
                    'name' => 'Name',
                    'label' => 'Displayed As',
                    'created_by' => 'Created By',
                    'created_at' => 'Created At',
                    'action' => 'Action',
                ))
                ->means('created_by', 'user.full_name')
                ->modify('action', function($status) {
                    return $status->viewer()->btnActions;
                })
                ->hidden(array('name', 'created_by', 'created_at'))
                ->render()
        }}

    @else
        <h5>There are no statuses to display.</h5>
    @endif

@stop