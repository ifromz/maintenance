@extends('maintenance::layouts.pages.main.grid')

@section('title', 'Events')

@section('grid.actions.create')
    <li class="primary">
        <a href="{{ route('maintenance.events.create') }}" data-toggle="tooltip" data-original-title="Create">
            <i class="fa fa-plus"></i> <span class="visible-xs-inline">Create</span>
        </a>
    </li>
@stop

@section('grid.table')

    <table id="data-grid" class="results table table-hover" data-source="{{ route('maintenance.api.v1.events.grid') }}" data-grid="main">

        <thead>
            <tr>
                <th><input data-grid-checkbox="all" type="checkbox"></th>
                <th>Title / Summary</th>
                <th class="sortable" data-sort="location_id">Location</th>
                <th>Start</th>
                <th>End</th>
            </tr>
        </thead>

        <tbody></tbody>

    </table>
@stop

@section('grid.results')
    @include('maintenance::events.grid.no-results')
    @include('maintenance::events.grid.results')
    @include('maintenance::events.grid.pagination')
    @include('maintenance::events.grid.filters')
@stop
