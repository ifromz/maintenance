{{-- Grid: Table --}}
<div class="table-responsive">

    <table id="inventory-stocks-movements-results" class="table table-hover"
           data-source="{{ route('maintenance.api.v1.inventory.stocks.movements.grid', [$item->id, $stock->id]) }}"
           data-grid="inventory-stocks-movements">

        <thead>
        <tr>
            <th>Change</th>
            <th class="sortable" data-sort="before">Before</th>
            <th class="sortable" data-sort="after">After</th>
            <th class="sortable" data-sort="cost">Cost</th>
            <th class="sortable" data-sort="reason">Reason</th>
            <th>Change By</th>
            <th>Change On</th>
        </tr>
        </thead>

        <tbody></tbody>

    </table>

</div>

<footer class="clearfix text-center">

    {{-- Grid: Pagination --}}
    <div id="inventory-stocks-movements-pagination" data-grid="inventory-stocks-movements"></div>

</footer>

@include('inventory.stocks.movements.grid.templates.no-results')
@include('inventory.stocks.movements.grid.templates.results')
@include('layouts.partials.grid.templates.pagination', ['grid' => 'inventory-stocks-movements'])
@include('layouts.partials.grid.templates.filters', ['grid' => 'inventory-stocks-movements'])

<script>

    $(function () {
        $.datagrid('inventory-stocks-movements', '#inventory-stocks-movements-results', '#inventory-stocks-movements-pagination', '#inventory-stocks-movements-filters');
    });

</script>