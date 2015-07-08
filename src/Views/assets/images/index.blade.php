@extends('maintenance::layouts.pages.main.panel')

@section('title', 'Images')

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

    {!! $asset->viewer()->images() !!}

@stop
