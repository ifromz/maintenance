@extends('work-orders.index')

@section('title', 'Assigned Work Orders')

@section('grid.table')
    <table id="data-grid" class="results table table-hover" data-source="{{ route('maintenance.api.v1.work-orders.assigned.grid') }}" data-grid="main">

        <thead>
            <tr>
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
