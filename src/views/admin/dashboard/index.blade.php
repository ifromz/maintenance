@extends('maintenance::layouts.admin')

@section('header')
	<h1>{{ $title }}</h1>
@stop

@section('breadcrumb')

@stop

@section('content')

<div class="col-lg-2 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-blue">
        <div class="inner">
            <h3>
                {{ $users }}
            </h3>
            <p>
                Users
            </p>
        </div>
        <div class="icon">
            <i class="ion ion-person"></i>
        </div>
        <a href="{{ route('maintenance.admin.users.index') }}" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div>
</div>

<div class="col-lg-2 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-yellow">
        <div class="inner">
            <h3>
                {{ $assets }}
            </h3>
            <p>
                Assets
            </p>
        </div>
        <div class="icon">
            <i class="fa fa-truck"></i>
        </div>
        <a href="#" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div>
</div>

<div class="col-lg-2 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-green">
        <div class="inner">
            <h3>
                {{ $inventories }}
            </h3>
            <p>
                Inventory Items
            </p>
        </div>
        <div class="icon">
            <i class="fa fa-gears"></i>
        </div>
        <a href="#" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div>
</div>

<div class="col-lg-2 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-blue">
        <div class="inner">
            <h3>
                {{ $workOrders }}
            </h3>
            <p>
                Work Orders
            </p>
        </div>
        <div class="icon">
            <i class="ion ion-wrench"></i>
        </div>
        <a href="#" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div>
</div>

@stop