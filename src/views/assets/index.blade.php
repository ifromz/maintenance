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
@stop

@section('panel.extra.top')

    @include('maintenance::assets.modals.search', array(
        'url' => route('maintenance.assets.index', Input::only('field', 'sort'))
    ))
    
@stop

@section('panel.head.content')
    
    <div class="btn-toolbar">
        <a href="{{ route('maintenance.assets.create') }}" class="btn btn-primary pull-left" data-toggle="tooltip" title="Create a new Asset">
            <i class="fa fa-plus"></i>
            New Asset
        </a>
        <a href="" class="btn btn-primary" data-target="#search-modal" data-toggle="modal" title="Filter results">
            <i class="fa fa-search"></i>
            Search
        </a>
    </div>

@stop

@section('panel.body.content')

    @if($assets->count() > 0)
    
        {{ $assets->columns(array(
                    'id' => 'ID',
                    'name' => 'Name',
                    'location' => 'Location',
                    'category' => 'Category',
                    'condition' => 'Condition',
                    'added_on' => 'Added On',
                    'action' => 'Action'
            ))
            ->means('location', 'location.trail')
            ->means('category', 'category.trail')
            ->means('added_on', 'created_at')
            ->modify('action', function($asset){
                return $asset->viewer()->btnActions;
            })
            ->sortable(array(
                'id',
                'name',
                'location' => 'location_id',
                'category' => 'category_id',
                'condition',
                'added_on' => 'created_at',
            ))
            ->render()
        }}
        
    @else
        <h5>There are no assets to display.</h5>
    @endif
    
    <div class="btn-toolbar text-center">
        {{ $assets->appends(Input::except('page'))->links() }}
    </div>
    
@stop