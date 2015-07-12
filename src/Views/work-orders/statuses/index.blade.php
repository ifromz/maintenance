@extends('maintenance::layouts.pages.main.grid')

@section('title', 'Statuses')

@section('grid.actions.create')
    <li class="primary">
        <a href="{{ route('maintenance.work-orders.statuses.create') }}" data-toggle="tooltip" data-original-title="Create">
            <i class="fa fa-plus"></i> <span class="visible-xs-inline">Create</span>
        </a>
    </li>
@stop

@section('grid.table')

    <table id="data-grid" class="results table table-hover" data-source="{{ route('maintenance.api.v1.work-orders.statuses.grid') }}" data-grid="main">

        <thead>
            <tr>
                <th class="sortable" data-sort="name">Name</th>
                <th class="sortable" data-sort="color">Color</th>
                <th class="sortable" data-sort="created_at">Created At</th>
                <th class="sortable" data-sort="user_id">Created By</th>
            </tr>
        </thead>

        <tbody></tbody>

    </table>
@stop

@section('grid.results')
    @include('maintenance::work-orders.statuses.grid.no-results')
    @include('maintenance::work-orders.statuses.grid.results')
    @include('maintenance::layouts.partials.grid.templates.pagination', ['grid' => 'main'])
    @include('maintenance::layouts.partials.grid.templates.filters', ['grid' => 'main'])
@stop
