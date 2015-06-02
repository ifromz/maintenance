@extends('maintenance::layouts.pages.main.grid')

@section('title', 'Inventory')

@section('grid.actions.create')
    <li class="primary">
        <a href="{{ route('maintenance.inventory.create') }}" data-toggle="tooltip" data-original-title="Create">
            <i class="fa fa-plus"></i> <span class="visible-xs-inline">Create</span>
        </a>
    </li>
@stop

@section('grid.table')
    <table id="data-grid" class="results table table-hover" data-source="{{ route('maintenance.api.v1.inventory.grid') }}" data-grid="main">

        <thead>
            <tr>
                <th><input data-grid-checkbox="all" type="checkbox"></th>
                <th class="sortable" data-sort="id">ID</th>
                <th>SKU</th>
                <th class="sortable" data-sort="name">Name</th>
                <th class="sortable" data-sort="category_id">Category</th>
                <th>Current Stock</th>
                <th class="sortable" data-sort="created_at">Created At</th>
            </tr>
        </thead>

        <tbody></tbody>

    </table>
@stop

@section('grid.results')
    @include('maintenance::inventory.grid.no-results')
    @include('maintenance::inventory.grid.results')
    @include('maintenance::inventory.grid.pagination')
    @include('maintenance::inventory.grid.filters')
@stop
