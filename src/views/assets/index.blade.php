@extends('maintenance::layouts.main')

@section('header')
	<h1>{{ $title }}</h1>
@stop

@section('breadcrumb')
<li>
    <a href="{{ route('maintenance.assets.index') }}">
        <i class="fa fa-truck"></i> 
        Assets
    </a>
</li>
@stop

@section('content')

    <div class="panel panel-default">
    	<div class="panel-heading">
            <div class="btn-toolbar">
                <a href="{{ route('maintenance.assets.create') }}" class="btn btn-primary pull-left" data-toggle="tooltip" title="Create a new Asset">
                    <i class="fa fa-plus"></i>
                    New Asset
                </a>
            </div>
        </div>
        
        <div class="panel-body">
        @if($assets->count() > 0)
        	<table class="table table-striped">
            	<thead>
                    <tr>
                        <th>ID</th>
                    	<th>Name</th>
                        <th>Location</th>
                        <th class="hidden-xs">Category</th>
                        <th>Condition</th>
                        <th class="hidden-xs">Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($assets as $asset)
                    <tr>
                        <td>{{ $asset->id }}</td>
                    	<td>{{ $asset->name }}</td>
                        <td>
                            @if($asset->location)
                            {{ renderNode($asset->location) }}
                            @else
                            <em>None</em>
                            @endif
                        </td>
                        <td class="hidden-xs">
                            {{ renderNode($asset->category) }}
                        </td>
                        <td>{{ $asset->condition }}</td>
                        <td class="hidden-xs">{{ $asset->created_at }}</td>
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                                    Action
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('maintenance.assets.show', array($asset->id)) }}">
                                            <i class="fa fa-search"></i> View Asset
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('maintenance.assets.edit', array($asset->id)) }}">
                                            <i class="fa fa-edit"></i> Edit Asset
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('maintenance.assets.destroy', array($asset->id)) }}" data-method="delete" data-message="Are you sure you want to delete this asset?">
                                            <i class="fa fa-trash-o"></i> Delete Asset
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
        	<p>There are no assets to display.</p>
        @endif
        </div>
            
        <div class="btn-toolbar text-center">
            {{ $assets->links() }}
        </div>
    </div>
    
@stop