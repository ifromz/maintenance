@extends('maintenance::layouts.pages.main.panel')

@section('header')
    <h1>{{ $title }}</h1>
@stop

@section('panel.extra.top')

    @include('maintenance::work-orders.modals.search', array(
        'url'=>route('maintenance.work-orders.index')
    ))

@stop

@section('panel.head.content')
    <div class="btn-toolbar">
        <a href="{{ route('maintenance.work-orders.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i>
            New Work Order
        </a>
        <a href="#" class="btn btn-primary" data-target="#search-modal" data-toggle="modal" title="Filter results">
            <i class="fa fa-search"></i>
            Search
        </a>
    </div>
@stop

@section('panel.body.content')

    @if($workOrders->count() > 0)

        {{

        $workOrders->columns(array(
                'id' => _t('ID'),
                'status' => _t('Status'),
                'priority' => _t('Priority'),
                'subject' => _t('Subject'),
                'description' => _t('Description'),
                'category' => _t('Category'),
                'created_by' => _t('Created By'),
                'created_at' => _t('Created At'),
                'action' => _t('Action')
            ))
            ->means('status', 'status.label')
            ->means('priority', 'priority.label')
            ->means('category', 'category.trail')
            ->means('created_by', 'user.full_name')
            ->means('description', 'limited_description')
            ->modify('action', function($workOrder){
                return $workOrder->viewer()->btnActions;
            })
            ->sortable(array(
                'id',
                'status'=>'status_id',
                'priority' => 'priority_id',
                'category' => 'category_id',
                'created_by' => 'user_id',
                'subject',
                'created_at'
            ))
            ->hidden(array('id', 'description', 'category', 'created_by', 'created_at'))
            ->showPages()
            ->render()
        }}

    @else

        <h5>{{ _t('There are no work orders to display.') }}</h5>

    @endif

@stop