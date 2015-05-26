@extends('maintenance::layouts.pages.main.panel')

@section('panel.head.content')
    <div class="btn-toolbar">
        <a href="{{ route('maintenance.inventory.create') }}" class="btn btn-primary" data-toggle="tooltip"
           title="Add new Item to inventory">
            <i class="fa fa-plus"></i>
            Add Stock
        </a>
    </div>
@stop

@section('panel.body.content')

    @if($item->stocks->count() > 0)

        {{
           $item->stocks->columns(array(
               'quantity_metric' => 'Quantity',
               'location' => 'Location',
               'last_movement' => 'Last Movement',
               'last_movement_by' => 'Last Movement By',
               'action' => 'Action',
           ))
           ->means('location', 'location.trail')
           ->modify('action', function($stock){
               return $stock->viewer()->btnActions();
           })
           ->hidden(array('last_movement', 'last_movement_by'))
           ->render()

       }}

    @else
        <h5>There are no stocks to display for this item.</h5>
    @endif

@stop
