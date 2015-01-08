@extends('maintenance::layouts.main')

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
        Assigned
    </li>
@stop

@section('content')

    <div class="panel panel-default">

        <div class="panel-heading">
            <h3 class="panel-title">My Assigned Work Orders</h3>
        </div>

        <div class="panel-body">

            @if($workOrders->count() > 0)

                {{ $workOrders->columns(array(
                                    'id' => 'ID',
                                    'status' => 'Status',
                                    'priority' => 'Priority',
                                    'subject' => 'Subject',
                                    'description' => 'Description',
                                    'category' => 'Category',
                                    'created_by' => 'Created By',
                                    'created_at' => 'Created At',
                                    'action' => 'Action'
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

                <h5>There are no work orders to display.</h5>

            @endif

        </div>

    </div>

@stop