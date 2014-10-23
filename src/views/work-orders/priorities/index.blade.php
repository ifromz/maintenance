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
    <i class="fa fa-exclamation-circle"></i> 
    Priorities
</li>
@stop

@section('content')

<div class="panel panel-default">
    
    <div class="panel-heading">
        <div class="btn-toolbar">
            <a href="{{ route('maintenance.work-orders.priorities.create') }}" class="btn btn-primary" data-toggle="tooltip" title="Create a new Priority">
                <i class="fa fa-plus"></i>
                New Priority
            </a>
        </div>
    </div>
    
    <div class="panel-body">
        
        @if($priorities->count() > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Color</th>
                    <th>Displayed As</th>
                    <th>Created By</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($priorities as $priority)
                <tr>
                    <td>{{ $priority->name }}</td>
                    <td>{{ $priority->color }}</td>
                    <td>{{ $priority->label }}</td>
                    <td>{{ $priority->user->full_name }}</td>
                    <td>{{ $priority->created_at }}</td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                                Action
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('maintenance.work-orders.priorities.edit', array($priority->id)) }}">
                                        <i class="fa fa-edit"></i> Edit Priority
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('maintenance.work-orders.priorities.destroy', array($priority->id)) }}" data-method="delete" data-message="Are you sure you want to delete this priority?">
                                        <i class="fa fa-trash-o"></i> Delete Priority
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
        <h5>There are no priorities to display.</h5>
        @endif
        
    </div>
    
</div>

@stop