@extends('maintenance::layouts.pages.main.panel')

@section('panel.head.content')
    <div class="btn-toolbar">
        <a class="btn btn-primary" data-toggle="modal" data-target="#update-reading-modal-{{ $meter->id }}">
            <i class="fa fa-plus-circle"></i>
            New Reading
        </a>
    </div>
@stop

@section('panel.extra.top')
    @include('maintenance::assets.modals.meters.update', [
        'asset' => $asset,
        'meter' => $meter
    ])
@stop

@section('panel.body.content')

    {!! $meter->viewer()->btnEditForAsset($asset) !!}

    {!! $meter->viewer()->btnDeleteForAsset($asset) !!}

    <hr>

    <div id="asset-meters-table">
        @if($readings->count() > 0)

            {!!
                $readings->columns([
                    'user' => 'User Responsible',
                    'reading' => 'Reading',
                    'created_at' => 'Created',
                    'action' => 'Action'
                ])
                ->means('user', 'user.full_name')
                ->means('reading', 'reading_with_metric')
                ->modify('action', function($reading) use($asset)
                {
                    return $reading->viewer()->btnActionsForAsset($asset);
                })
                ->render()
            !!}
        @else
            <h5>There are no readings to display for this meter.</h5>
        @endif

        <div class="btn-toolbar text-center">
            {!! $readings->appends(Input::except('page'))->render() !!}
        </div>
    </div>
@stop
