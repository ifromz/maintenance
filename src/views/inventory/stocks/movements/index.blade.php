@extends('maintenance::layouts.pages.main.panel')

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

        {!!
            $movements->columns([
                'id' => 'ID',
                'user' => 'User',
                'before' => 'Before Quantity',
                'after' => 'After Quantity',
                'change' => 'Change',
                'cost' => 'Cost',
                'reason' => 'Reason',
                'created_at' => 'Date',
                'action' => 'Action'
            ])
            ->means('user', 'user.full_name')
            ->modify('change', function($movement) use($item) {
                return $movement->change . ' ' . $item->metric->name;
            })
            ->modify('action', function($movement) use($item, $stock){
                return $movement->viewer()->btnActions($item, $stock);
            })
            ->hidden(['before', 'after', 'reason'])
            ->sortable([
                'id',
                'user' => 'user_id',
                'before',
                'after',
                'cost',
                'created_at',
            ])
            ->render()
        !!}

        <div class="text-center">{!! $movements->appends(Input::except('page'))->render() !!}</div>

    @else
        <h5>There are currently no stock movements for this item</h5>
    @endif

@stop
