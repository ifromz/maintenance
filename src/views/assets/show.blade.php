@extends('maintenance::layouts.main')

@section('header')
	<h1>{{ $title }}</h1>
@stop

@section('content')
	<div class="nav-tabs-custom">
		<ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">Asset</a></li>
                    <li class=""><a href="#tab_2" data-toggle="tab">Work Orders</a></li>
                    <li class=""><a href="#tab_3" data-toggle="tab">Details</a></li>
                    <li class=""><a href="#tab_4" data-toggle="tab">Manuals</a></li>
                    <li class=""><a href="#tab_5" data-toggle="tab">QR Code</a></li>
                    <li class="dropdown pull-right">
       			<a href="#" class="text-muted dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gear"></i></a>
        		<ul class="dropdown-menu">
                            <li role="presentation">
                		<a role="menuitem" href="{{ route('maintenance.assets.images.index', array($asset->id)) }}"><i class="fa fa-search"></i> View Images</a>
                            </li>
                            <li role="presentation">
                		<a role="menuitem" href="{{ route('maintenance.assets.images.create', array($asset->id)) }}"><i class="fa fa-plus-circle"></i> Add Images</a>
                            </li>
                            <li class="divider"></li>
                            <li role="presentation">
                		<a role="menuitem" href="{{ route('maintenance.assets.edit', array($asset->id)) }}"><i class="fa fa-pencil"></i> Edit</a>
                            </li>
                            <li role="presentation">
                                <a data-method="delete" data-message="Are you sure you want to delete this asset? This will also remove all manuals." href="{{ route('maintenance.assets.destroy', array($asset->id)) }}" role="menuitem">
                                    <i class="fa fa-trash-o"></i> Delete
                                </a>
                            </li>
       			</ul>
                    </li>
		</ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    @include('maintenance::assets.tabs.index', compact('asset'))
                </div>

                <div class="tab-pane" id="tab_2">
                    @include('maintenance::assets.tabs.work-orders', compact('asset'))
                </div>

                <div class="tab-pane" id="tab_3">
                </div>

                <div class="tab-pane" id="tab_4">
                    @include('maintenance::assets.tabs.manuals', compact('asset'))
                </div>
                
                <div class="tab-pane" id="tab_5">
                  {{ DNS2D::getBarcodeSVG(route('maintenance.assets.show', array($asset->id)), "QRCODE") }}
                </div>
            </div>
	</div>

@stop