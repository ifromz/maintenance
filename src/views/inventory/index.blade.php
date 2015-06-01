@extends('maintenance::layouts.pages.main.panel')

@section('title', 'Inventory')

@section('panel.extra.top')

    @include('maintenance::inventory.modals.search', [
        'url' => route('maintenance.inventory.index', Input::only('field', 'sort', 'per_page'))
    ])

@stop

@section('panel.head.content')
    <div class="btn-toolbar">
        <a href="{{ route('maintenance.inventory.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i>
            New Item
        </a>
        <a href="#" class="btn btn-primary" data-target="#search-modal" data-toggle="modal" title="Filter results">
            <i class="fa fa-search"></i>
            Search
        </a>

        <div class="col-md-2 pull-right">
            @include('maintenance::select.records-per-page')
        </div>
    </div>
@stop

@section('panel.body.content')

    @if($items->count() > 0)

        {!!
            $items->columns([
                'id' => 'ID',
                'name' => 'Name',
                'category' => 'Category',
                'current_stock' => 'Current Stock',
                'description' => 'Description',
                'created_at' => 'Added On',
                'action'  => 'Action'
            ])
            ->means('category', 'category.trail')
            ->modify('current_stock', function ($item) {
                return $item->viewer()->lblCurrentStock();
            })
            ->modify('action', function ($item) {
                return $item->viewer()->btnActions();
            })
            ->sortable([
                'id',
                'name',
                'category' => 'category_id',
                'added_on' => 'created_at',
            ])
            ->hidden(['id', 'added_on', 'description'])
            ->render()
        !!}

        <div class="text-center">{!! $items->render() !!}</div>

    @else

        <h5>There are no inventory items to list.</h5>

    @endif

@stop
