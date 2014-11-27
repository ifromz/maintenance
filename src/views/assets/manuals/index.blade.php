@extends('maintenance::layouts.pages.main.panel')

@section('header')
	<h1>{{ $title }}</h1>
@stop

@section('breadcrumb')
<li>
    <a href="{{ route('maintenance.assets.index') }}">
        <i class="fa fa-truck"></i> 
        Assets
    </a>
</li>
<li>
    <a href="{{ route('maintenance.assets.show', array($asset->id)) }}"> 
        {{ $asset->name }}
    </a>
</li>
<li class="active">
    Manuals
</li>
@stop

@section('panel.head.content')

 <div class="btn-toolbar">
    <a href="{{ route('maintenance.assets.manuals.create', array($asset->id)) }}" class="btn btn-primary" data-toggle="tooltip" title="Upload Asset Manuals">
        <i class="fa fa-plus"></i>
        Upload Manuals
    </a>
 </div>

@stop

@section('panel.body.content')

    @if($asset->manuals->count() > 0)
    
        {{ $asset->manuals
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