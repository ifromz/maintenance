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
    <li class="active">
        <i class="fa fa-wrench"></i>
        Work Orders
    </li>
@stop

@section('content')

    @include('maintenance::work-orders.modals.search', array(
        'url'=>route(currentRouteName())
    ))

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="btn-toolbar">
                <a href="#" class="btn btn-primary" data-target="#search-modal" data-toggle="modal"
                   title="Filter results">
                    <i class="fa fa-search"></i>
                    Search
                </a>
            </div>
        </div>

        <div id="resource-paginate" class="panel-body">
            @if($workOrders->count() > 0)
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>{{ link_to_sort(currentRouteName(), 'ID', array('field'=>'id', 'sort'=>'asc')) }}</th>
                        <th>{{ link_to_sort(currentRouteName(), 'Status', array('field'=>'status', 'sort'=>'asc')) }}</th>
                        <th>{{ link_to_sort(currentRouteName(), 'Priority', array('field'=>'priority', 'sort'=>'asc')) }}</th>
                        <th>{{ link_to_sort(currentRouteName(), 'Subject', array('field'=>'subject', 'sort'=>'asc')) }}</th>
                        <th>{{ link_to_sort(currentRouteName(), 'Description', array('field'=>'description', 'sort'=>'asc')) }}</th>
                        <th>{{ link_to_sort(currentRouteName(), 'Category', array('field'=>'category_id', 'sort'=>'asc')) }}</th>
                        <th>{{ link_to_sort(currentRouteName(), 'Created By', array('field'=>'user', 'sort'=>'asc')) }}</th>
                        <th>{{ link_to_sort(currentRouteName(), 'Created At', array('field'=>'created_at', 'sort'=>'asc')) }}</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody class="workOrder-body">
                    @foreach($workOrders as $workOrder)
                        <tr>
                            <td>{{ $workOrder->id }}</td>
                            <td>{{ $workOrder->status->label }}</td>
                            <td>
                                {{ $workOrder->priority->label }}
                            </td>
                            <td>{{ $workOrder->subject }}</td>
                            <td>{{ str_limit($workOrder->description) }}</td>
                            <td>
                                {{ $workOrder->category->trail }}
                            </td>
                            <td>{{ $workOrder->user->full_name }}</td>
                            <td>{{ $workOrder->created_at }}</td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                                        Action
                                        <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{{ route('maintenance.admin.archive.work-orders.restore', array($workOrder->id)) }}"
                                               data-method="POST"
                                               data-message="Are you sure you want to restore this asset?">
                                                <i class="fa fa-refresh"></i> Restore
                                            </a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a href="{{ route('maintenance.admin.archive.work-orders.show', array($workOrder->id)) }}">
                                                <i class="fa fa-search"></i> View
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('maintenance.admin.archive.work-orders.destroy', array($workOrder->id)) }}"
                                               data-method="delete"
                                               data-message="Are you sure you want to permanently delete this work order? You will not be able to recover this data.">
                                                <i class="fa fa-trash-o"></i> Delete (Permanent)
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <h5>There are no work orders to display.</h5>
            @endif

            <div class="text-center">{{ $workOrders->appends(Input::except('page'))->links() }}</div>
        </div>
    </div>

@stop