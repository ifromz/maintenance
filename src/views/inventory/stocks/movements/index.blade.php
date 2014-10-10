@extends('maintenance::layouts.main')

@section('header')
	<h1>{{ $title }}</h1>
@stop

@section('breadcrumb')
<li>
    <a href="{{ route('maintenance.inventory.index') }}">
        <i class="fa fa-dropbox"></i> 
        Inventory
    </a>
</li>
<li>
    <a href="{{ route('maintenance.inventory.show', array($item->id)) }}"> 
        {{ $item->name }}
    </a>
</li>
<li>
    {{ renderNode($stock->location) }}
</li>
<li>
    Movements
</li>
@stop

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="btn-toolbar">
                <a href="#" class="btn btn-primary" data-target="#search-modal" data-toggle="modal" title="Filter results">
                    <i class="fa fa-search"></i>
                    Search
                </a>
            </div>
        </div>
            
        <div class="panel-body">
            @if($movements->count() > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Before Quantity</th>
                        <th>After Quantity</th>
                        <th>Change</th>
                        <th>Cost</th>
                        <th>Reason</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($movements as $movement)
                    <tr>
                        <td>{{ $movement->user->full_name }}</td>
                        <td>{{ $movement->before }}</td>
                        <td>{{ $movement->after }}</td>
                        <td>{{ $movement->change }}</td>
                        <td>{{ $movement->cost }}</td>
                        <td>{{ $movement->reason }}</td>
                        <td>{{ $movement->created_at }}</td>
                    </tr>
                    @endforeach
                    
                    <div class="btn-toolbar text-center">
                        {{ $movements->appends(Input::except('page'))->links() }}
                    </div>
                </tbody>
            </table>
            @else
                <h5>There are currently no stock movements for this item</h5>
            @endif
        </div>
    </div>
@stop