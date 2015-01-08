@extends('maintenance::layouts.main')

@section('header')
    <h1>{{ $title }}</h1>
@stop

@section('breadcrumb')

@stop

@section('content')

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_movements" data-toggle="tab">Movements</a></li>
            <li><a href="#tab_timeline" data-toggle="tab">Timeline</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_movements">
                @include('maintenance::inventory.stocks.movements.index', array(
                    'stock' => $stock
                ))
            </div>
            <div class="tab-pane" id="tab_timeline">
                <div class="col-md-12">
                    @include('maintenance::inventory.stocks.movements.timeline', array(
                        'stock' => $stock
                    ))
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

@stop