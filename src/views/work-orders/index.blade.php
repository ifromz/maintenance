@extends('maintenance::layouts.pages.main.grid')

@section('title', 'Work Orders')

@section('grid.actions.create')
    <li class="primary">
        <a href="{{ route('maintenance.work-orders.create') }}" data-toggle="tooltip" data-original-title="Create">
            <i class="fa fa-plus"></i> <span class="visible-xs-inline">Create</span>
        </a>
    </li>
@stop

@section('grid.table')
    <table id="data-grid" class="results table table-hover" data-source="{{ route('maintenance.api.v1.work-orders.grid') }}" data-grid="main">

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
    @include('maintenance::work-orders.grid.no-results')
    @include('maintenance::work-orders.grid.results')
    @include('maintenance::work-orders.grid.pagination')
    @include('maintenance::work-orders.grid.filters')
@stop
