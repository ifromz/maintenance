@extends('maintenance::layouts.pages.main.panel')

@section('panel.head.content')
    <div class="btn-toolbar">
        <a href="{{ route('maintenance.work-orders.statuses.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i>
            New Status
        </a>
    </div>
@stop

@section('panel.body.content')

    @if($statuses->count() > 0)

        {!!
            $statuses->columns([
                'name' => 'Name',
                'label' => 'Displayed As',
                'created_by' => 'Created By',
                'created_at' => 'Created At',
                'action' => 'Action',
            ])
            ->means('created_by', 'user.full_name')
            ->modify('action', function($status) {
                return $status->viewer()->btnActions();
            })
            ->hidden(['name', 'created_by', 'created_at'])
            ->render()
        !!}

    @else
        <h5>There are no statuses to display.</h5>
    @endif

@stop
