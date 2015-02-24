@extends('maintenance::layouts.pages.main.panel')

@section('header')
    <h1>{{ $title }}</h1>
@stop

@section('panel.head.content')

    <div class="btn-toolbar">
        <a href="{{ route('maintenance.assets.manuals.create', array($asset->id)) }}" class="btn btn-primary"
           data-toggle="tooltip" title="Upload Asset Manuals">
            <i class="fa fa-plus"></i>
            Upload Manuals
        </a>
    </div>

@stop

@section('panel.body.content')

    @if($asset->manuals->count() > 0)

        {{
            $asset->manuals
                ->columns(array(
                    'name' => 'Name',
                    'file_name' => 'File Name',
                    'action' => 'Action',
                ))
                ->modify('action', function($manual) use($asset) {
                    return $manual->viewer()->btnActionsForAssetManual($asset);
                })
                ->render()
        }}

    @else

        <h5>There are currently no asset manuals to list.</h5>

    @endif

@stop