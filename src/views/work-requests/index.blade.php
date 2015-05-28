@extends('maintenance::layouts.pages.main.grid')

@section('title', 'Work Requests')

@section('grid.title', 'Work Requests')

@section('grid.actions.create')
    <li class="primary">
        <a href="{{ route('maintenance.work-requests.create') }}" data-toggle="tooltip" data-original-title="Create">
            <i class="fa fa-plus"></i> <span class="visible-xs-inline">Create</span>
        </a>
    </li>
@stop

@section('grid.table')

    <table id="data-grid" class="results table table-hover" data-source="{{ route('management.metrics.grid') }}" data-grid="main">

        <thead>
            <tr>
                <th><input data-grid-checkbox="all" type="checkbox"></th>
                <th class="sortable" data-sort="name">Name</th>
                <th class="sortable" data-sort="symbol">Symbol</th>
                <th class="sortable" data-sort="created_at">Created</th>
            </tr>
        </thead>

        <tbody></tbody>

    </table>
@stop

@section('grid.results')
    @include('pages.management.metrics.grid.no-results')
    @include('pages.management.metrics.grid.results')
    @include('pages.management.metrics.grid.pagination')
    @include('pages.management.metrics.grid.filters')
@stop
