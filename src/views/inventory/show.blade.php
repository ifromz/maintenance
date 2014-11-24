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
            <li><a href="#tab_history" data-toggle="tab">History</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_profile">
                
                {{ $item->viewer()->btnQrCode }}
                
                {{ $item->viewer()->btnAddStock }}
                
                {{ $item->viewer()->btnEdit }}
                
                {{ $item->viewer()->btnDelete }}
                
                <hr>
                
                {{ $item->viewer()->stock }}
                
            </div>
            
            <div class="tab-pane" id="tab_history">
                {{ $item->viewer()->history }}
            </div>
        </div>
    </div>

@stop