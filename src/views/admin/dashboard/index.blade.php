@extends('maintenance::layouts.admin')

@section('header')
    <h1>{{ $title }}</h1>
@stop

@section('breadcrumb')

@stop

@section('content')

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Users</span>
                <span class="info-box-number">{{ $users }}</span>
                <a href="{{ route('maintenance.admin.users.index') }}" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-truck"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Assets</span>
                <span class="info-box-number">{{ $assets }}</span>
                <a href="{{ route('maintenance.admin.users.index') }}" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-dropbox"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Inventory</span>
                <span class="info-box-number">{{ $inventories }}</span>
                <a href="{{ route('maintenance.admin.users.index') }}" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-book"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Work Orders</span>
                <span class="info-box-number">{{ $workOrders }}</span>
                <a href="{{ route('maintenance.admin.users.index') }}" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
    </div>

@stop