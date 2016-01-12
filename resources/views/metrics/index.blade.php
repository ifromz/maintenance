@extends('layouts.pages.main.grid')

@section('title', 'Metrics')

@section('grid.actions.create')
    <li class="primary">
        <a href="{{ route('maintenance.metrics.create') }}" data-toggle="tooltip" data-original-title="Create">
            <i class="fa fa-plus"></i> <span class="visible-xs-inline">Create</span>
        </a>
    </li>
@endsection

@section('grid.table')
    <table id="data-grid" class="results table table-hover" data-source="{{ route('maintenance.api.v1.metrics.grid') }}"
           data-grid="main">

        <thead>
        <tr>
            <th class="sortable" data-sort="id">ID</th>
            <th class="sortable" data-sort="name">Name</th>
            <th class="sortable" data-sort="symbol">Symbol</th>
            <th class="sortable" data-sort="created_at">Created At</th>
            <th class="sortable" data-sort="user_id">Created By</th>
        </tr>
        </thead>

        <tbody></tbody>

    </table>
@endsection

@section('grid.results')
    @include('metrics.grid.no-results')
    @include('metrics.grid.results')
    @include('metrics.grid.pagination')
    @include('metrics.grid.filters')
@endsection
