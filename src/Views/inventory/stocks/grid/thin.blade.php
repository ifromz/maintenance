{{-- Grid: Table --}}
<div class="table-responsive">

    <table id="inventory-stocks-results" class="table table-hover" data-source="{{ route('maintenance.api.v1.inventory.stocks.grid', [$item->id]) }}" data-grid="inventory-stocks">

        <thead>
            <tr>
                <th class="sortable" data-sort="quantity">Quantity</th>
                <th class="sortable" data-sort="location_id">Location</th>
                <th>Last Movement</th>
                <th>Last Movement By</th>
            </tr>
        </thead>

        <tbody></tbody>

    </table>

</div>

<footer class="clearfix text-center">

    {{-- Grid: Pagination --}}
    <div id="inventory-stocks-pagination" data-grid="inventory-stocks"></div>

</footer>

@include('maintenance::inventory.stocks.grid.templates.no-results')
@include('maintenance::inventory.stocks.grid.templates.results')
@include('maintenance::layouts.partials.grid.templates.pagination', ['grid' => 'inventory-stocks'])
@include('maintenance::layouts.partials.grid.templates.filters', ['grid' => 'inventory-stocks'])

<script>

    $(function()
    {
        $.datagrid('inventory-stocks', '#inventory-stocks-results', '#inventory-stocks-pagination', '#inventory-stocks-filters');
    });

</script>