@extends('maintenance::layouts.pages.main.tabbed')

@section('header')
    <h1>{{ $title }}</h1>
@stop

@section('breadcrumb')
    <li>
        <a href="{{ route('maintenance.inventory.index') }}">
            <i class="fa fa-dropbox"></i>
            Inventory
        </a>
    </li>
    <li>
        <a href="{{ route('maintenance.inventory.show', array($item->id)) }}">
            {{ $item->name }}
        </a>
    </li>
    <li>
        Stock: {{ $stock->location->name }}
    </li>
    <li class="active">
        Movement: {{ $movement->id }}
    </li>
@stop

@section('tab.head.content')
    <li class="active"><a href="#tab_profile" data-toggle="tab">Profile</a></li>
@stop

@section('tab.body.content')

    <div class="tab-pane active" id="tab_profile">

        {{ $movement->viewer()->btnRollback($item, $stock) }}

        <hr>

        {{ $movement->viewer()->profile }}
    </div>

@stop