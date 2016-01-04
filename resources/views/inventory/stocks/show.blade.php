@extends('layouts.pages.main.tabbed')

@section('title', 'Viewing Stock')

@section('tab.head.content')
    <li class="active"><a href="#tab_profile" data-toggle="tab">Profile</a></li>
@stop

@section('tab.body.content')

    <div class="tab-pane active" id="tab_profile">

        {!! $stock->viewer()->btnEdit() !!}

        {!! $stock->viewer()->btnDelete() !!}

        <hr>

        {!! $stock->viewer()->profile() !!}

        <hr>

        <h3>Movements</h3>

        @include('inventory.stocks.movements.grid.thin', compact('item', 'stock'))

    </div>
@stop
