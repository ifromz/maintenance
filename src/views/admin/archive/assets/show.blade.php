@extends('maintenance::layouts.admin')

@section('header')
<h1>{{ $title }}</h1>
@stop

@section('content')

<div class="panel panel-default">
    
    <div class="panel-heading">
        <h3 class="panel-title">Limited View While viewing in Archive</h3>
    </div>
    
    <div class="panel-body">
        
        <a href="{{ route('maintenance.admin.archive.assets.restore', array($asset->id)) }}" 
            data-method="post"
            data-title="Restore Asset?"
            data-message="Are you sure you want to restore this asset?" 
            class="btn btn-app">
             <i class="fa fa-refresh"></i> Restore
        </a>
        
        <a href="{{ route('maintenance.admin.archive.assets.destroy', array($asset->id)) }}" 
            data-method="delete"
            data-title="Delete asset?"
            data-message="Are you sure you want to delete this asset? All data for this asset will be lost, and won't be recoverable." 
            class="btn btn-app">
             <i class="fa fa-trash-o"></i> Delete (Permanent)
        </a>
        
        <hr>
        
        <div class="col-md-9">
            @include('maintenance::assets.tabs.profile.description', array('asset'=>$asset))
            
            <legend>More Information:</legend>
            
            <dl class="dl-horizontal">
                <dt>Work Orders Attached To:</dt>
                <dd>{{ $asset->workOrders->count() }}</dd>

                <p></p>
                
                <dt>Manuals / Attachments:</dt>
                <dd>{{ $asset->manuals->count() }}</dd>

                <p></p>
                
                <dt>Events:</dt>
                <dd>{{ $asset->events->count() }}</dd>

                <p></p>
            </dl>
        </div>

        <div class="col-md-3">
            @include('maintenance::assets.tabs.profile.images', array('asset'=>$asset))
        </div>
    </div>
    
</div>

@stop