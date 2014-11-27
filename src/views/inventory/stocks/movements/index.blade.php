@extends('maintenance::layouts.pages.main.panel')

@section('header')
	<h1>{{ $title }}</h1>
@stop

@section('breadcrumb')
<li>
    <a href="{{ route('maintenance.inventory.index') }}">
        <i class="fa fa-dropbox"></i> 
        Inventory
    </a>
</li>
<li>
    <a href="{{ route('maintenance.inventory.show', array($item->id)) }}"> 
        {{ $item->name }}
    </a>
</li>
<li>
    {{ $stock->location->trail }}
</li>
<li>
    Movements
</li>
@stop

@section('panel.head.content')
    <div class="btn-toolbar">
        <a href="#" class="btn btn-primary" data-target="#search-modal" data-toggle="modal" title="Filter results">
            <i class="fa fa-search"></i>
            Search
        </a>
    </div>
@stop

@section('panel.body.content')

    @if($movements->count() > 0)

        {{ $movements->columns(array(
                        'user' => 'User',
                        'before' => 'Before Quantity',
                        'after' => 'After Quantity',
                        'change' => 'Change',
                        'cost' => 'Cost',
                        'reason' => 'Reason',
                        'created_at' => 'Date',
                    ))
                    ->means('user', 'user.full_name')
                    ->modify('change', function($movement) use($item) {
                        return $movement->change . ' ' . $item->metric->name;
                    })
                    ->hidden(array('before', 'after', 'reason'))
                    ->sortable(array(
                        'user' => 'user_id',
                        'before',
                        'after',
                        'cost',
                        'created_at',
                    ))
                    ->showPages()
                    ->render() }}

    @else
        <h5>There are currently no stock movements for this item</h5>
    @endif

@stop