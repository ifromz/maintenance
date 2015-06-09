@extends('maintenance::layouts.pages.main.tabbed')

@section('title', 'Viewing Asset')

@section('tab.head.content')
    <li class="active"><a href="#tab-profile" data-toggle="tab">Profile</a></li>
    <li><a href="#tab-history" data-toggle="tab">History</a></li>
    <li><a href="#tab-meters" data-toggle="tab">Meters & Readings</a></li>
    <li><a href="#tab-calendar" data-toggle="tab">Calendar</a></li>
    <li><a href="#tab-images" data-toggle="tab">Images</a></li>
    <li><a href="#tab-manuals" data-toggle="tab">Manuals</a></li>
@stop

@section('tab.body.content')

    <div class="tab-pane active" id="tab-profile">

        <div class="row">

            <div class="col-md-12">

                {!! $asset->viewer()->btnEvents() !!}

                {!! $asset->viewer()->btnWorkOrders() !!}

                {!! $asset->viewer()->btnViewImages() !!}

                {!! $asset->viewer()->btnAddImages() !!}

                {!! $asset->viewer()->btnEdit() !!}

                {!!$asset->viewer()->btnDelete() !!}

            </div>

            <div class="col-md-6">
                <h2>Profile</h2>

                {!! $asset->viewer()->profile() !!}
            </div>

            <div class="col-md-6">
                <h2>Images</h2>

                {!! $asset->viewer()->slideshow() !!}
            </div>
        </div>

    </div>

    <div class="tab-pane" id="tab-meters">

        {!! $asset->viewer()->btnAddMeter() !!}

        <h2>Meters & Readings</h2>

        {!! $asset->viewer()->meters() !!}

    </div>

    <div class="tab-pane" id="tab-history">
        {!! $asset->viewer()->history() !!}
    </div>

    <div class="tab-pane" id="tab-calendar">

        <h2>Calendar</h2>

        {!! $asset->viewer()->calendar() !!}
    </div>

    <div class="tab-pane" id="tab-images">

        {!! $asset->viewer()->btnAddImages() !!}

        <h2>Images</h2>

        {!! $asset->viewer()->images() !!}

    </div>

    <div class="tab-pane" id="tab-manuals">

        {!! $asset->viewer()->btnAddManuals() !!}

        <h2>Manuals</h2>

        {!! $asset->viewer()->manuals() !!}

    </div>

@stop
