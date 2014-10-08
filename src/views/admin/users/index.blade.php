@extends('maintenance::layouts.admin')

@section('header')
	<h1>{{ $title }}</h1>
@stop

@section('breadcrumb')

@stop

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="btn-toolbar">
                <a href="{{ route('maintenance.admin.users.create') }}" class="btn btn-primary" data-toggle="tooltip" title="Create a new User">
                    <i class="fa fa-plus"></i>
                    New User
                </a>
                <a href="#" class="btn btn-primary" data-target="#search-modal" data-toggle="modal" title="Filter results">
                    <i class="fa fa-search"></i>
                    Search
                </a>
            </div>
        </div>
        
        <div id="resource-paginate" class="panel-body">
            
            <div class="text-center">{{ $users->links() }}</div>
            
            @if($users->count() > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->full_name }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
            
            <div class="text-center">{{ $users->links() }}</div>
        </div>
    </div>
            
@stop