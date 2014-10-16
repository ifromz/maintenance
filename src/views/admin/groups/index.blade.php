@extends('maintenance::layouts.admin')

@section('header')
<h1>{{ $title }}</h1>
@stop

@section('content')

<div class="panel panel-default">
    
    <div class="panel-heading">
        <div class="btn-toolbar">
            <a href="{{ route('maintenance.admin.groups.create') }}" class="btn btn-primary" data-toggle="tooltip" title="Create a new User Group">
                <i class="fa fa-plus"></i>
                New Group
            </a>
            <a href="#" class="btn btn-primary" data-target="#search-modal" data-toggle="modal" title="Filter results">
                <i class="fa fa-search"></i>
                Search
            </a>
        </div>
    </div>
    
    <div class="panel-body">
        
        @if($groups->count() > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($groups as $group)
                <tr>
                    <td>{{ $group->id }}</td>
                    <td>{{ $group->name }}</td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                                Action
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('maintenance.admin.groups.show', array($group->id)) }}">
                                        <i class="fa fa-search"></i> View Group
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('maintenance.admin.groups.edit', array($group->id)) }}">
                                        <i class="fa fa-edit"></i> Edit Group
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('maintenance.admin.groups.destroy', array($group->id)) }}" 
                                       data-method="delete" 
                                       data-message="Are you sure you want to delete this group?">
                                        <i class="fa fa-trash-o"></i> Delete Group
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
        <h5>There are current no groups to show</h5>
        @endif
        
    </div>
    
</div>

@stop