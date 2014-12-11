@extends('maintenance::layouts.pages.main.tabbed')

@section('title')
<h1>{{ $title }}</h1>
@stop

@section('breadcrumb')

@stop

@section('tab.head.content')
    <li class="active"><a href="#tab_profile" data-toggle="tab">Profile</a></li>
@stop

@section('tab.body.content')
    <div class="tab-pane active" id="tab_profile">

        {{ $event->viewer()->profile }}
        
    </div>
@stop