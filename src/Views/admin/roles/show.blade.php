@extends('maintenance::layouts.pages.admin.tabbed')

@section('title', 'Viewing Group')

@section('tab.head.content')
    <li class="active"><a href="#tab_1" data-toggle="tab">Profile</a></li>
    <li><a href="#tab_2" data-toggle="tab">Users</a></li>
    <li><a href="#tab_3" data-toggle="tab">Permissions</a></li>
@stop

@section('tab.body.content')
    <div class="tab-pane active" id="tab_1">
        {!! $role->viewer()->profile()  !!}
    </div>

    <div class="tab-pane" id="tab_2">
        {!! $role->viewer()->users() !!}
    </div>

    <div class="tab-pane" id="tab_3">
        {!! $role->viewer()->permissions() !!}
    </div>
@stop
