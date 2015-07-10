{{-- Inventory Variants Grid --}}

{{-- Grid: Table --}}
<div class="table-responsive">

    <table id="inventory-variants-results" class="table table-hover" data-source="{{ route('api.v1.inventory.variants.grid', [$item->id]) }}" data-grid="inventory-variants">

        <thead>
            <tr>
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

</div>

<footer class="clearfix text-center">

    {{-- Grid: Pagination --}}
    <div id="inventory-variants-pagination" data-grid="inventory-variants"></div>

</footer>

@include('maintenance::inventory.variants.grid.templates.no-results')
@include('maintenance::inventory.variants.grid.templates.results')
@include('maintenance::layouts.partials.grid.templates.pagination', ['grid' => 'inventory-variants'])
@include('maintenance::layouts.partials.grid.templates.filters', ['grid' => 'inventory-variants'])
