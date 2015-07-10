@extends('maintenance::layouts.pages.main.tabbed')

@section('title', "Viewing Item: $item->name")

@section('tab.head.content')
    <li class="active"><a href="#tab-profile" data-toggle="tab">Profile</a></li>
    <li><a href="#tab-variants" data-toggle="tab">Variants</a></li>
    <li><a href="#tab-calendar" data-toggle="tab">Calendar</a></li>
    <li><a href="#tab-notes" data-toggle="tab">Notes</a></li>
    <li><a href="#tab-history" data-toggle="tab">History</a></li>
@stop

@section('tab.body.content')
    <div class="tab-pane active" id="tab-profile">
        <div class="row">
            <div class="col-md-12">

                {!! $item->viewer()->btnEvents() !!}

                {!! $item->viewer()->btnRegenerateSku() !!}

                {!! $item->viewer()->btnEdit() !!}

                {!! $item->viewer()->btnDelete() !!}

            </div>

            <div class="clear-fix"></div>

            <div class="col-md-6">
                <h2>Profile</h2>

                {!! $item->viewer()->profile() !!}
            </div>

            <div class="clear-fix"></div>

            <div class="col-md-12">

                <h2>
                    Stocks

                    <button class="btn btn-default" data-toggle="tooltip" data-original-title="Refresh" data-grid="inventory-stocks" data-reset>
                        <i class="fa fa-refresh fa-sm"></i>
                    </button>

                    {!! $item->viewer()->btnAddStock() !!}
                </h2>

                @include('maintenance::inventory.stocks.grid.thin', compact('item'))
            </div>
        </div>
    </div>

    <div class="tab-pane" id="tab-variants">
        <h2>
            Variants

            <button class="btn btn-default" data-toggle="tooltip" data-original-title="Refresh" data-grid="inventory-variants" data-reset>
                <i class="fa fa-refresh fa-sm"></i>
            </button>
            <a class="btn btn-default" data-toggle="tooltip" data-original-title="Create Variant" href="{{ route('maintenance.inventory.variants.create', [$item->id]) }}">
                <i class="fa fa-plus"></i>
            </a>
        </h2>

        @include('maintenance::inventory.variants.grid.thin', compact('item'))
    </div>

    <div class="tab-pane" id="tab-calendar">
        {!! $item->viewer()->calendar() !!}
    </div>

    <div class="tab-pane" id="tab-notes">
        {!! $item->viewer()->btnAddNote() !!}

        <hr>

        {!! $item->viewer()->notes() !!}
    </div>

    <div class="tab-pane" id="tab-history">
        {!! $item->viewer()->history() !!}
    </div>
@stop
