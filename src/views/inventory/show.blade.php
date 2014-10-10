@extends('maintenance::layouts.main')

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
<li class="active">
    {{ $item->name }}
</li>
@stop

@section('content')
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_profile" data-toggle="tab">Profile</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_profile">
                @include('maintenance::inventory.tabs.profile', array(
                    'item'=>$item
                ))
            </div>
        </div>
    </div>

@stop