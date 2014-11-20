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
        <i class="fa fa-truck"></i>
        Assets
</li>
@stop

@section('content')
    
    @include('maintenance::assets.modals.search', array(
        'url' => route('maintenance.admin.archive.assets.index', Input::only('field', 'sort'))
    ))

    <div class="panel panel-default">
        
    	<div class="panel-heading">
            <div class="btn-toolbar">
                <a href="" class="btn btn-primary" data-target="#search-modal" data-toggle="modal" title="Filter results">
                    <i class="fa fa-search"></i>
                    Search
                </a>
            </div>
        </div>
        
        <div id="resource-paginate" class="panel-body">
            @if($assets->count() > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>{{ link_to_sort(currentRouteName(), 'ID', array('field'=>'id', 'sort'=>'asc')) }}</th>
                        <th>{{ link_to_sort(currentRouteName(), 'Name', array('field'=>'name', 'sort'=>'asc')) }}</th>
                        <th>{{ link_to_sort(currentRouteName(), 'Location', array('field'=>'location_id', 'sort'=>'asc')) }}</th>
                        <th class="hidden-xs">{{ link_to_sort(currentRouteName(), 'Category', array('field'=>'category_id', 'sort'=>'asc')) }}</th>
                        <th>{{ link_to_sort(currentRouteName(), 'Condition', array('field'=>'condition', 'sort'=>'asc')) }}</th>
                        <th>{{ link_to_sort(currentRouteName(), 'Deleted At', array('field'=>'deleted_at', 'sort'=>'asc')) }}</th>
                        <th class="hidden-xs">{{ link_to_sort(currentRouteName(), 'Created At', array('field'=>'created_at', 'sort'=>'asc')) }}</th>
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
                            {{ $asset->location->trail }}
                            @else
                            <em>None</em>
                            @endif
                        </td>
                        <td class="hidden-xs">
                            {{ $asset->category->trail }}
                        </td>
                        <td>{{ $asset->condition }}</td>
                        <td>{{ $asset->deleted_at }}</td>
                        <td class="hidden-xs">{{ $asset->created_at }}</td>
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                                    Action
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('maintenance.admin.archive.assets.restore', array($asset->id)) }}"
                                           data-method="POST"
                                           data-message="Are you sure you want to restore this asset?">
                                            <i class="fa fa-refresh"></i> Restore
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="{{ route('maintenance.admin.archive.assets.show', array($asset->id)) }}">
                                            <i class="fa fa-search"></i> View
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('maintenance.admin.archive.assets.destroy', array($asset->id)) }}" 
                                           data-method="delete" 
                                           data-message="Are you sure you want to permanently delete this asset? You will not be able to recover this data.">
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
                <p>There are no assets to display.</p>
        @endif
        </div>
            
    </div>
    
@stop