@extends('maintenance::layouts.admin')

@section('header')
<h1>{{ $title }}</h1>
@stop

@section('content')

<div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab">Profile</a></li>
            <li><a href="#tab_2" data-toggle="tab">Users</a></li>
            <li><a href="#tab_3" data-toggle="tab">Permissions</a></li>
        </ul>
        <div class="tab-content">
            
            <div class="tab-pane active" id="tab_1">
                @include('maintenance::admin.groups.tabs.profile', array(
                    'group'=>$group
                ))
            </div>
            
            <div class="tab-pane" id="tab_2">
                @include('maintenance::admin.groups.tabs.users', array(
                    'group'=>$group
                ))
            </div>
            
            <div class="tab-pane" id="tab_3">
                @include('maintenance::admin.groups.tabs.permissions', array(
                    'group'=>$group
                ))
            </div>
            
        </div>
</div>

@stop