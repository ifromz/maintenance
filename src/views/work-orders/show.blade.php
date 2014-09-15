@extends('maintenance::layouts.main')

@section('header')
	<h1>{{ $title }}</h1>
@stop

@section('content')
    <script src="{{ asset('packages/stevebauman/maintenance/js/work-orders/show.js') }}"></script>
    <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">Profile</a></li>
                <li class=""><a href="#tab_2" data-toggle="tab">Details</a></li>
                <li class=""><a href="#tab_3" data-toggle="tab">Parts</a></li>
                <li class=""><a href="#tab_4" data-toggle="tab">History</a></li>
                <li class=""><a href="#tab_5" data-toggle="tab">Photos</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    @include('maintenance::work-orders.tabs.profile', array('workOrder'=>$workOrder))
                </div><!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2">
                   @include('maintenance::work-orders.tabs.details', array('workOrder'=>$workOrder))
                </div><!-- /.tab-pane -->
                <div class="tab-pane" id="tab_3">
                
                </div>
                <div class="tab-pane" id="tab_4">
                    @include('maintenance::work-orders.tabs.sessions', array($workOrder))
                </div>
                <div class="tab-pane" id="tab_5">
                    
                </div>
            </div><!-- /.tab-content -->
        </div>

@stop