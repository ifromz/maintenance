@extends('maintenance::layouts.main')

@section('header')
	<h1>{{ $title }}</h1>
@stop

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            <div class="btn-toolbar">
                <a href="{{ route('maintenance.assets.manuals.create', array($asset->id)) }}" class="btn btn-primary" data-toggle="tooltip" title="Upload Asset Manuals">
                    <i class="fa fa-plus"></i>
                    Upload Images
                </a>
            </div>
        </div>
    </div>
    <div class="panel-body">
        @if($asset->manuals->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th class="hidden-xs">File Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($asset->manuals as $manual)
                <tr>
                    <td>{{ $manual->name }}</td>
                    <td class="hidden-xs">{{ $manual->file_name }}</td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                                Action
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ $manual->manual_link }}">
                                        <i class="fa fa-search"></i> View Manual
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('maintenance.assets.manuals.destroy', array($asset->id, $manual->id)) }}" data-method="delete" data-message="Are you sure you want to delete this asset?">
                                        <i class="fa fa-trash-o"></i> Delete Manual
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
            
        <h5>There are currently no asset manuals to list.</h5>
        
        @endif
    </div>
</div>
@stop