@extends('maintenance::layouts.pages.admin.panel')

@section('panel.extra.top')
    @include('maintenance::inventory.modals.search', array(
        'url' => route(currentRouteName(), Input::only('field', 'sort'))
    ))
@stop

@section('panel.head.content')
    <div class="btn-toolbar">
        <a href="#" class="btn btn-primary" data-target="#search-modal" data-toggle="modal"
           title="Filter results">
            <i class="fa fa-search"></i>
            Search
        </a>
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
               'added_on' => 'Added On',
               'action'  => 'Action',
           ])
           ->means('category', 'category.trail')
           ->means('added_on', 'created_at')
           ->modify('action', function($item) {
               return $item->viewer()->btnActionsArchive();
           })
           ->sortable([
               'id',
               'name',
               'category' => 'category_id',
               'added_on' => 'created_at',
           ])
           ->hidden(['id', 'added_on', 'description'])
           ->showPages()
           ->render()
       !!}
    @else
        <h5>There are no archived inventory items to display.</h5>
    @endif

@stop
