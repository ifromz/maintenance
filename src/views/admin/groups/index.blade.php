@extends('maintenance::layouts.pages.admin.panel')

@section('panel.head.content')
    <div class="btn-toolbar">
        <a href="{{ route('maintenance.admin.groups.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i>
            New Group
        </a>
        <a href="#" class="btn btn-primary" data-target="#search-modal" data-toggle="modal"
           title="Filter results">
            <i class="fa fa-search"></i>
            Search
        </a>
    </div>
@stop

@section('panel.body.content')
    @if($groups->count() > 0)

        {{
            $groups->columns(array(
                'id' => 'ID',
                'name' => 'Name',
                'members' => '# of Members',
                'action' => 'Action',
            ))
            ->modify('members', function($group){
                return count($group->users);
            })
            ->modify('action', function($group){
                return $group->viewer()->btnActions();
            })
            ->render()
        }}

    @else
        <h5>There are current no groups to show</h5>
    @endif
@stop
