@extends('maintenance::layouts.pages.main.panel')

@section('panel.head.content')
    <div class="btn-toolbar">
        <a href="{{ route('maintenance.assets.images.create', [$asset->id]) }}" class="btn btn-primary"
           data-toggle="tooltip" title="Upload Asset Images">
            <i class="fa fa-plus"></i>
            Upload Images
        </a>
    </div>
@stop

@section('panel.body.content')

    @if($asset->images->count() > 0)

        {{
            $asset->images
                ->columns([
                    'image' => 'Image',
                    'created_at' => 'Uploaded',
                    'file_name' => 'File Name',
                    'action' => 'Action',
                ])
                ->modify('image', function($image) {
                    return $image->viewer()->tagImageThumbnail;
                })
                ->modify('action', function($image) use ($asset) {
                    return $image->viewer()->btnActionsForAssetImage($asset);
                })
                ->render();
        }}

    @else

        <h5>There are currently no asset images to list.</h5>

    @endif
@stop
