@extends('maintenance::layouts.pages.admin.panel')

@section('panel.extra.top')
    @include('maintenance::admin.users.modals.search', array(
        'url' => route('maintenance.admin.users.index'),
    ))
@stop

@section('panel.head.content')
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
@stop

@section('panel.body.content')
<div class="text-center">{{ $users->links() }}</div>

@if($users->count() > 0)

    {{
        $users
            ->columns(array(
                'id' => 'ID',
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
@stop