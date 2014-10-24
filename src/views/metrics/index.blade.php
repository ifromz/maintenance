@extends('maintenance::layouts.main')

@section('header')
	<h1>{{ $title }}</h1>
@stop

@section('breadcrumb')
<li>
    <i class="fa fa-anchor"></i> 
    Metrics
</li>
@stop

@section('content')

<div class="panel panel-default">
    
    <div class="panel-heading">
        <div class="btn-toolbar">
            <a href="{{ route('maintenance.metrics.create') }}" class="btn btn-primary" data-toggle="tooltip" title="Create a new Metric">
                <i class="fa fa-plus"></i>
                New Metric
            </a>
        </div>
    </div>
    
    <div class="panel-body">
        
        @if($metrics->count() > 0)
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Symbol</th>
                    <th>Created By</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($metrics as $metric)
                <tr>
                    <td>{{ $metric->name }}</td>
                    <td>{{ $metric->symbol }}</td>
                    <td>{{ $metric->user->full_name }}</td>
                    <td>{{ $metric->created_at }}</td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                                Action
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('maintenance.metrics.edit', array($metric->id)) }}">
                                        <i class="fa fa-edit"></i> Edit Metric
                                    </a>
                                </li>
                                <li>
                                    <a 
                                        href="{{ route('maintenance.metrics.destroy', array($metric->id)) }}" 
                                        data-method="delete" 
                                        data-message="Are you sure you want to delete this metric? 
                                        Anything that was attached to this metric will need to be set to a new metric after deletion.">
                                        <i class="fa fa-trash-o"></i> Delete Metric
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
        <h5>There are no metrics to display.</h5>
        @endif
        
    </div>
    
</div>

@stop