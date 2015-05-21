@extends('maintenance::layouts.pages.main.panel')

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

        {{
            $metrics->columns([
                'name' => 'Name',
                'symbol' => 'Symbol',
                'created_by' => 'Created By',
                'created_at' => 'Created At',
                'action' => 'Action',
            ])
            ->means('created_by', 'user.full_name')
            ->modify('action', function($metric) {
                return $metric->viewer()->btnActions;
            })
            ->hidden(['created_by', 'created_at'])
            ->sortable([
                'name',
                'symbol',
                'created_by',
                'created_at',
            ])
            ->render()
        }}

    @else
        <h5>There are no metrics to display.</h5>
    @endif

@stop
