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
    <i class="fa fa-info-circle"></i> 
    Statuses
</li>
@stop

@section('content')

<div class="panel panel-default">
    
    <div class="panel-heading">
        <div class="btn-toolbar">
            <a href="{{ route('maintenance.work-orders.statuses.create') }}" class="btn btn-primary" data-toggle="tooltip" title="Create a new Status">
                <i class="fa fa-plus"></i>
                New Status
            </a>
        </div>
    </div>
    
    <div class="panel-body">
        
        @if($statuses->count() > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Displayed As</th>
                    <th>Created By</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($statuses as $status)
                <tr>
                    <td>{{ $status->name }}</td>
                    <td>{{ $status->label }}</td>
                    <td>{{ $status->user->full_name }}</td>
                    <td>{{ $status->created_at }}</td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                                Action
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('maintenance.work-orders.statuses.edit', array($status->id)) }}">
                                        <i class="fa fa-edit"></i> Edit Status
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('maintenance.work-orders.statuses.destroy', array($status->id)) }}" data-method="delete" data-message="Are you sure you want to delete this status?">
                                        <i class="fa fa-trash-o"></i> Delete Status
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
        <h5>There are no statuses to display.</h5>
        @endif
        
    </div>
    
</div>

@stop