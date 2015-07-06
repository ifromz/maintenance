{{-- Meter Readings Grid --}}

{{-- Grid: Table --}}
<div class="table-responsive">

    <table id="meters-readings-results" class="table table-hover" data-source="{{ route('api.v1.assets.meters.readings.grid', [$asset->id, $meter->id]) }}" data-grid="meters-readings">

        <thead>
            <tr>
                <th class="sortable" data-sort="reading">Reading</th>
                <th class="sortable" data-sort="comment">Comment</th>
                <th class="sortable" data-sort="user_id">User</th>
                <th class="sortable" data-sort="created_at">Created At</th>
            </tr>
        </thead>

        <tbody></tbody>

    </table>

</div>

<footer class="clearfix text-center">

    {{-- Grid: Pagination --}}
    <div id="meters-readings-pagination" data-grid="meters-readings"></div>

</footer>

@include('maintenance::assets.meters.readings.grid.templates.no-results')
@include('maintenance::assets.meters.readings.grid.templates.results')
@include('maintenance::assets.meters.readings.grid.templates.pagination')
@include('maintenance::assets.meters.readings.grid.templates.filters')
