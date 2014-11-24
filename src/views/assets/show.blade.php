@extends('maintenance::layouts.main')

@section('header')
	<h1>{{ $title }}</h1>
@stop

@section('breadcrumb')
<li>
    <a href="{{ route('maintenance.assets.index') }}">
        <i class="fa fa-truck"></i> 
        Assets
    </a>
</li>
<li class="active">
    {{ $asset->name }}
</li>
@stop

@section('content')
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_asset" data-toggle="tab">Profile</a></li>
            <li class=""><a href="#tab_history" data-toggle="tab">History</a></li>
            <li class=""><a href="#tab_meters" data-toggle="tab">Meters & Readings</a></li>
            <li class=""><a href="#tab_calendar" data-toggle="tab">Calendar</a></li>
            <li class=""><a href="#tab_work_orders" data-toggle="tab">Work Orders</a></li>
            <li class=""><a href="#tab_manuals" data-toggle="tab">Manuals</a></li>
        </ul>
        <div class="tab-content">
            
            <div class="tab-pane active" id="tab_asset">
                
                {{ $asset->viewer()->btnQrCode }}
                
                {{ $asset->viewer()->btnCalendars }}
                
                {{ $asset->viewer()->btnAddImages }}
                
                {{ $asset->viewer()->btnViewImages }}
                
                {{ $asset->viewer()->btnEdit }}
                
                {{ $asset->viewer()->btnDelete }}
                
                <hr>
                
                <div class="col-md-9">
                    {{ $asset->viewer()->profile }}
                </div>
                
                <div class="col-md-3">
                    {{ $asset->viewer()->slideshow }}
                </div>
                
                <div class="clearfix"></div>
                
            </div>
            
            <div class="tab-pane" id="tab_meters">
                
                <legend>Meters & Readings</legend>
                
                {{ $asset->viewer()->btnAddMeter }}
                
                <hr>
                
                {{ $asset->viewer()->meters }}
                
            </div>
            
            <div class="tab-pane" id="tab_history">
                {{ $asset->viewer()->history }}
            </div>

            <div class="tab-pane" id="tab_calendar">
                {{ $asset->viewer()->calendar }}
            </div>

            <div class="tab-pane" id="tab_work_orders">
                {{ $workOrders->columns(array(
                            'id' => 'ID',
                            'status' => 'Status',
                            'priority' => 'Priority',
                            'subject' => 'Subject',
                            'description' => 'Description',
                        ))
                        ->means('status', 'status.label')
                        ->means('priority', 'priority.label')
                        ->actions('btnActions')
                        ->sortable(array(
                            'id'
                        ))
                        ->showPages()
                        ->render() }}
            </div>

            <div class="tab-pane" id="tab_manuals">
                @include('maintenance::assets.tabs.manuals', array('asset'=>$asset))
            </div>
        </div>
    </div>
@stop