@extends('maintenance::layouts.pages.main.tabbed')

@section('title', 'Viewing Asset Meter')

@section('tab.head.content')
    <li class="active"><a href="#tab-profile" data-toggle="tab">Profile</a></li>
    <li><a href="#tab-readings" data-toggle="tab">Readings</a></li>
@stop

@section('tab.body.content')
    <div class="tab-pane active" id="tab-profile">

        {!! $meter->viewer()->btnEditForAsset($asset) !!}

        {!! $meter->viewer()->btnDeleteForAsset($asset) !!}

        <hr>

        <h3>Profile</h3>

    </div>

    <div class="tab-pane" id="tab-readings">
        @include('maintenance::assets.meters.readings.grid.index', compact('asset, meter'))
    </div>
@stop

@section('scripts')

@stop
