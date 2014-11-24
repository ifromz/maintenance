@extends('maintenance::layouts.main')

@section('header')
    <h1>{{ $title }}</h1>
@stop

@section('breadcrumb')
<li>
    <a href="{{ route('maintenance.work-orders.index') }}">
        <i class="fa fa-book"></i> 
        Work Orders
    </a>
</li>
<li class="active">
    {{ $workOrder->subject }}
</li>
@stop

@section('content')

    <div class="nav-tabs-custom">
        
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_profile" data-toggle="tab">Profile</a></li>
            <li class=""><a href="#tab_details" data-toggle="tab">Details</a></li>
            <li class=""><a href="#tab_history" data-toggle="tab">History</a></li>
            <li class=""><a href="#tab_parts" data-toggle="tab">Parts / Supplies</a></li>
            <li class=""><a href="#tab_attachments" data-toggle="tab">Attachments</a></li>
        </ul>
        
        <div class="tab-content">
            
            <div class="tab-pane active" id="tab_profile">
                
                <legend>Profile</legend>

                {{ $workOrder->viewer()->btnCheckIn }}

                {{ $workOrder->viewer()->btnWorkers }}

                {{ $workOrder->viewer()->btnNotifications }}

                {{ $workOrder->viewer()->btnComplete }}

                {{ $workOrder->viewer()->btnEdit }}

                {{ $workOrder->viewer()->btnDelete }}

                <div class="clearfix"></div>

                <hr>

                {{ $workOrder->viewer()->profile }}
                
            </div>
            
            <div class="tab-pane" id="tab_details">
                
                {{ $workOrder->viewer()->report }}
                
                {{ $workOrder->viewer()->sessions }}
                
            </div>
            
            <div class="tab-pane" id="tab_history">
                
                {{ $workOrder->viewer()->history }}
                
            </div>
            
            <div class="tab-pane" id="tab_parts">
                
                <legend>Parts / Supplies</legend>
                
                {{ $workOrder->viewer()->btnAddParts }}
                
                <hr>
                
                {{ $workOrder->viewer()->parts }}
                
            </div>
            
            <div class="tab-pane" id="tab_attachments">
                
                <legend>Attachments</legend>
                
                {{ $workOrder->viewer()->btnAddAttachments }}
                
                <hr>
                
                {{ $workOrder->viewer()->attachments }}
            </div>
            
        </div>
        
    </div>
    
    <div class="clearfix"></div>
    
    {{ $workOrder->viewer()->customerUpdates }}

@stop