@extends('maintenance::layouts.pages.main.tabbed')

@section('tab.head.content')
    <li class="active"><a href="#tab_profile" data-toggle="tab">Profile</a></li>
@stop

@section('tab.body.content')

    <div class="tab-pane active" id="tab_profile">

        {!! $stock->viewer()->btnEdit() !!}

        {!! $stock->viewer()->btnDelete() !!}

        <hr>

        {!! $stock->viewer()->profile() !!}

        <legend>Last 10 Movements</legend>

        {!!
            $lastMovements->columns([
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
                ->modify('action', function($movement) use($item, $stock) {
                    return $movement->viewer()->btnActions($item, $stock);
                })
                ->render()
        !!}

    </div>
@stop
