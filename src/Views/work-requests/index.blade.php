@extends('maintenance::layouts.pages.main.grid')

@section('title', 'Work Requests')

@section('grid.actions.create')
    <li class="primary">
        <a href="{{ route('maintenance.work-requests.create') }}" data-toggle="tooltip" data-original-title="Create">
            <i class="fa fa-plus"></i> <span class="visible-xs-inline">Create</span>
        </a>
    </li>
@stop

@section('grid.table')

    <table id="data-grid" class="results table table-hover" data-source="{{ route('maintenance.api.v1.work-requests.grid') }}" data-grid="main">

        <thead>
            <tr>
                <th class="sortable" data-sort="subject">Subject</th>
                <th class="sortable" data-sort="best_time">Best Time</th>
                <th class="sortable" data-sort="created_at">Created</th>
            </tr>
        </thead>

        <tbody></tbody>

    </table>
@stop

@section('grid.results')
    @include('maintenance::work-requests.grid.no-results')
    @include('maintenance::work-requests.grid.results')
    @include('maintenance::work-requests.grid.pagination')
    @include('maintenance::work-requests.grid.filters')
@stop
