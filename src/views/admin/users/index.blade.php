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
                <a href="{{ route('maintenance.admin.users.create') }}" class="btn btn-primary">
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

        @include('maintenance::admin.users.modals.search', array(
            'url' => route('maintenance.admin.users.index'),
        ))

        <div id="resource-paginate" class="panel-body">

            <div class="text-center">{{ $users->links() }}</div>

            @if($users->count() > 0)

                {{

                $users
                    ->columns(array(
                        'name' => 'Name',
                        'username' => 'Username',
                        'email' => 'Email',
                        'action' => 'Action'
                    ))
                    ->modify('name', function($user){
                        return $user->full_name;
                    })
                    ->modify('action', function($user){
                        return $user->viewer()->btnActions;
                    })
                    ->hidden(array(
                        'name'
                    ))
                    ->render()

                }}

            @endif

            <div class="text-center">{{ $users->links() }}</div>
        </div>
    </div>

@stop