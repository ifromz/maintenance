@extends('maintenance::layouts.pages.main.panel')

@section('header')
    <h1>{{ $title }}</h1>
@stop

@section('breadcrumb')
    <li>
        <i class="fa fa-anchor"></i>
        Metrics
    </li>
@stop

@section('panel.head.content')

    <div class="btn-toolbar">
        <a href="{{ route('maintenance.metrics.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i>
            New Metric
        </a>
    </div>
    
@stop

@section('panel.body.content')

    @if($metrics->count() > 0)

        {{ $metrics->columns(array(
                    'name' => 'Name',
                    'symbol' => 'Symbol',
                    'created_by' => 'Created By',
                    'created_at' => 'Created At',
                    'action' => 'Action',
                ))
                ->means('created_by', 'user.full_name')
                ->modify('action', function($metric) {
                    return $metric->viewer()->btnActions;
                })
                ->hidden(array('created_by', 'created_at'))
                ->sortable(array(
                    'name',
                    'symbol',
                    'created_by',
                    'created_at',
                ))
                ->render()
        }}

    @else
        <h5>There are no metrics to display.</h5>
    @endif

@stop