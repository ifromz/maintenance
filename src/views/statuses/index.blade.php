@extends('maintenance::layouts.main')

@section('header')
	<h1>{{ $title }}</h1>
@stop

@section('content')

    <div class="panel panel-default">
    	<div class="panel-heading">
        	<div class="panel-title">
            	<div class="btn-toolbar">
                    <a href="{{ route('maintenance.statuses.create') }}" class="btn btn-primary" data-toggle="tooltip" title="Create a new Status">
                        <i class="fa fa-plus"></i>
                        New Status
                    </a>
                </div>
            </div>
        </div>
        
        <div class="panel-body">
        @if($statuses->count() > 0)
        	<table class="table">
           		<thead>
                	<tr>
                    	<th>Name</th>
                        <th>Color</th>
                        <th>Work Orders (#)</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
               	@foreach($statuses as $status)
                	<tr>
                    	<td>{{ $status->name }}</td>
                        <td><span class="label label-{{ $status->color }}">{{ $status->color }}</span></td>
                        <td>{{ $status->workOrders->count() }}</td>
                        <td>{{ $status->created_at }}</td>
                        <td>
                         <div class="btn-group">
                              <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                                  Action
                                  <span class="caret"></span>
                              </a>
                              <ul class="dropdown-menu">
                                  <li>
                                      <a href="{{ route('maintenance.statuses.edit', array($status->id)) }}">
                                          <i class="fa fa-edit"></i>&nbsp;Edit Status
                                      </a>
                                  </li>
                                  <li>
                                      <a href="{{ route('maintenance.statuses.destroy', array($status->id)) }}"
                                         data-method="delete"
                                         data-message="Are you sure you want to delete this status?">
                                          <i class="fa fa-trash-o"></i>&nbsp;Delete Status
                                      </a>
                                  </li>
                              </ul>
                          </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
      	@endif
        </div>
    </div>
@stop