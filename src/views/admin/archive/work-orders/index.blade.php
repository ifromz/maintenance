@extends('maintenance::layouts.pages.admin.panel')

@section('panel.extra.top')
    @include('maintenance::work-orders.modals.search', array(
        'url'=>route(currentRouteName())
    ))
@stop

@section('panel.head.content')
    <div class="btn-toolbar">
        <a href="#" class="btn btn-primary" data-target="#search-modal" data-toggle="modal"
           title="Filter results">
            <i class="fa fa-search"></i>
            Search
        </a>
    </div>
@stop

@section('panel.body.content')
    @if($workOrders->count() > 0)
        {{
            $workOrders->columns(array(
                'id' => 'ID',
                'completed' => 'Completed',
                'status' => 'Status',
                'priority' => 'Priority',
                'subject' => 'Subject',
                'description' => 'Description',
                'category' => 'Category',
                'created_by' => 'Created By',
                'created_at' => 'Created At',
                'action' => 'Action',
            ))
            ->means('status', 'status.label')
            ->means('priority', 'priority.label')
            ->means('category', 'category.trail')
            ->means('created_by', 'user.full_name')
            ->means('description', 'limited_description')
            ->modify('action', function($workOrder){
                return $workOrder->viewer()->btnActionsArchive;
            })
            ->render()
        }}
    @else
        <h5>There are no archived work orders to display.</h5>
    @endif
@stop
