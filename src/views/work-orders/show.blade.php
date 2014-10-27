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
                @include('maintenance::work-orders.tabs.profile', array('workOrder'=>$workOrder))
            </div>
            
            <div class="tab-pane" id="tab_details">
                @include('maintenance::work-orders.tabs.details', array('workOrder'=>$workOrder))
                
                @include('maintenance::work-orders.tabs.sessions', array('workOrder'=>$workOrder))
            </div>
            
            <div class="tab-pane" id="tab_history">
                @include('maintenance::partials.history-table', array('record'=>$workOrder))
            </div>
            
            <div class="tab-pane" id="tab_parts">
                @include('maintenance::work-orders.tabs.parts', array('workOrder'=>$workOrder))
            </div>
            
            <div class="tab-pane" id="tab_attachments">
                @include('maintenance::work-orders.tabs.attachments', array('workOrder'=>$workOrder))
            </div>
            
        </div>
        
    </div>
    
    <div class="clearfix"></div>
    
    @include('maintenance::work-orders.partials.update-box', array('workOrder'=>$workOrder))

@stop