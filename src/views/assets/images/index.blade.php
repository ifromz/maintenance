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
<li>
    <a href="{{ route('maintenance.assets.show', array($asset->id)) }}">
        {{ $asset->name }}
    </a>
</li>
<li class="active">
    <i class="fa fa-picture-o"></i>
    Images
</li>
@stop

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            <div class="btn-toolbar">
                <a href="{{ route('maintenance.assets.images.create', array($asset->id)) }}" class="btn btn-primary" data-toggle="tooltip" title="Upload Asset Images">
                    <i class="fa fa-plus"></i>
                    Upload Images
                </a>
            </div>
        </div>
    </div>
    <div class="panel-body">
        @if($asset->images->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th class="hidden-xs">File Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($asset->images as $image)
                <tr>
                    <td width="200">
                        <img class="img-responsive" src="{{ Storage::url($image->file_path.$image->file_name) }}">
                    </td>
                    <td>{{ $image->name }}</td>
                    <td class="hidden-xs">{{ $image->file_name }}</td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                                Action
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('maintenance.assets.images.show', array($asset->id, $image->id)) }}">
                                        <i class="fa fa-search"></i> View Image
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('maintenance.assets.images.destroy', array($asset->id, $image->id)) }}" data-method="delete" data-message="Are you sure you want to delete this image?">
                                        <i class="fa fa-trash-o"></i> Delete Image
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
        
        <h5>There are currently no asset images to list.</h5>
        
        @endif
    </div>
</div>
@stop