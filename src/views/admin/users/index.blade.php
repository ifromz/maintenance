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
                <a href="{{ route('maintenance.admin.users.create') }}" class="btn btn-primary" data-toggle="tooltip"
                   title="Create a new User">
                    <i class="fa fa-plus"></i>
                    New User
                </a>
                <a href="#" class="btn btn-primary" data-target="#search-modal" data-toggle="modal"
                   title="Filter results">
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
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                                        Action
                                        <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{{ route('maintenance.admin.users.show', array($user->id)) }}">
                                                <i class="fa fa-search"></i> View User
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('maintenance.admin.users.edit', array($user->id)) }}">
                                                <i class="fa fa-edit"></i> Edit User
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('maintenance.admin.users.destroy', array($user->id)) }}"
                                               data-method="delete"
                                               data-message="Are you sure you want to delete this user?">
                                                <i class="fa fa-trash-o"></i> Delete User
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

            <div class="text-center">{{ $users->links() }}</div>
        </div>
    </div>

@stop