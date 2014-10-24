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
    Assigned
</li>
@stop

@section('content')

<div class="panel panel-default">
    
    <div class="panel-heading">
        <h3 class="panel-title">My Assigned Work Orders</h3>
    </div>
    
    <div class="panel-body">
        @if($workOrders->count() > 0)
        
        @else
        <h5>You are not assigned to any work orders.</h5>
        @endif
    </div>
    
</div>

@stop