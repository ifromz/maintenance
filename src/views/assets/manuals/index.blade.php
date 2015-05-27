@extends('maintenance::layouts.pages.main.panel')

@section('panel.head.content')

    <div class="btn-toolbar">
        <a href="{{ route('maintenance.assets.manuals.create', [$asset->id]) }}" class="btn btn-primary"
           data-toggle="tooltip" title="Upload Asset Manuals">
            <i class="fa fa-plus"></i>
            Upload Manuals
        </a>
    </div>

@stop

@section('panel.body.content')

    @if($asset->manuals->count() > 0)

        {!!
            $asset->manuals
                ->columns([
                    'file_name' => 'File Name',
                    'created_at' => 'Uploaded',
                    'action' => 'Action',
                ])
                ->modify('action', function($manual) use($asset) {
                    return $manual->viewer()->btnActionsForAssetManual($asset);
                })
                ->render()
        !!}

    @else

        <h5>There are currently no asset manuals to list.</h5>

    @endif

@stop
