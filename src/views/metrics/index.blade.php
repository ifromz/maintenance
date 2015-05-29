@extends('maintenance::layouts.pages.main.grid')

@section('title', 'Metrics')

@section('grid.actions.create')
    <li class="primary">
        <a href="{{ route('maintenance.metrics.create') }}" data-toggle="tooltip" data-original-title="Create">
            <i class="fa fa-plus"></i> <span class="visible-xs-inline">Create</span>
        </a>
    </li>
@stop

@section('grid.table')
    <table id="data-grid" class="results table table-hover" data-source="{{ route('maintenance.api.v1.metrics.grid') }}" data-grid="main">

        <thead>
        <tr>
            <th><input data-grid-checkbox="all" type="checkbox"></th>
            <th class="sortable" data-sort="id">ID</th>
            <th class="sortable" data-sort="subject">Subject</th>
            <th class="sortable" data-sort="created_at">Created At</th>
            <th class="sortable" data-sort="user_id">Created By</th>
            <td>Priority</td>
            <td>Status</td>
        </tr>
        </thead>

        <tbody></tbody>

    </table>
@stop

@section('grid.results')
    @include('maintenance::metrics.grid.no-results')
    @include('maintenance::metrics.grid.results')
    @include('maintenance::metrics.grid.pagination')
    @include('maintenance::metrics.grid.filters')
@stop
