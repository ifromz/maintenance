{{-- Inventory Stocks Grid --}}
<section class="panel panel-default panel-grid">

    {{-- Grid: Header --}}
    <header class="panel-heading">

        <nav class="navbar navbar-default navbar-actions">

            <div class="container-fluid">

                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#inventory-stocks-actions">
                        <span class="fa fa-bars"></span>
                    </button>
                </div>

                {{-- Grid: Actions --}}
                <div class="collapse navbar-collapse" id="inventory-stocks-actions">

                    <ul class="nav navbar-nav navbar-left">

                        <li class="dropdown">
                            <a href="#" data-grid-exporter class="dropdown-toggle tip" data-toggle="dropdown" role="button" aria-expanded="false" data-original-title="Export">
                                <i class="fa fa-download"></i> <span class="visible-xs-inline">Export</span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#" data-download="pdf" data-toggle="tooltip" data-original-title="Export Results as PDF"><i class="fa fa-file-pdf-o"></i> PDF</a></li>
                                <li><a href="#" data-download="csv" data-toggle="tooltip" data-original-title="Export Results as CSV"><i class="fa fa-file-excel-o"></i> CSV</a></li>
                                <li><a href="#" data-download="json" data-toggle="tooltip" data-original-title="Export Results as JSON"><i class="fa fa-file-code-o"></i> JSON</a></li>
                            </ul>
                        </li>

                    </ul>

                    {{-- Grid: Filters --}}
                    <form class="navbar-form navbar-right" method="post" accept-charset="utf-8" data-search data-grid="inventory-stocks" role="form">

                        <div class="input-group">

                                <span class="input-group-btn">

                                    <button class="btn btn-default" type="button" disabled>
                                        Filters
                                    </button>

                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>

                                    <ul class="dropdown-menu" role="menu">

                                        <li>
                                            <a data-grid-calendar-preset="day">
                                                <i class="fa fa-calendar"></i> Today
                                            </a>
                                        </li>

                                        <li>
                                            <a data-grid-calendar-preset="week">
                                                <i class="fa fa-calendar"></i> This Week
                                            </a>
                                        </li>

                                        <li>
                                            <a data-grid-calendar-preset="month">
                                                <i class="fa fa-calendar"></i> This Month
                                            </a>
                                        </li>

                                    </ul>

                                    <button class="btn btn-default hidden-xs" type="button" data-grid-calendar data-range-filter="created_at">
                                        <i class="fa fa-calendar"></i>
                                    </button>

                                </span>

                            <input class="form-control" name="filter" type="text" placeholder="Search">

                                <span class="input-group-btn">

                                    <button data-toggle="tooltip" data-original-title="Search" class="btn btn-default" type="submit">
                                        <span class="fa fa-search"></span>
                                    </button>

                                    <button data-toggle="tooltip" data-original-title="Refresh" class="btn btn-default" data-grid="inventory-stocks" data-reset>
                                        <i class="fa fa-refresh fa-sm"></i>
                                    </button>

                                </span>

                        </div>

                    </form>

                </div>

            </div>

        </nav>

    </header>

    {{-- Page header --}}
    <div class="panel-body">

        {{-- Grid: Applied Filters --}}
        <div class="btn-toolbar" role="toolbar" aria-label="data-grid-applied-filters">

            <div id="inventory-stocks-filters" class="btn-group" data-grid="inventory-stocks"></div>

        </div>

    </div>

    {{-- Grid: Table --}}
    <div class="table-responsive">

        <table id="inventory-stocks-results" class="table table-hover" data-source="{{ route('maintenance.api.v1.work-orders.parts.inventory.stocks.grid', [$workOrder->id, $item->id]) }}" data-grid="inventory-stocks">

            <thead>
            <tr>
                <th class="sortable" data-sort="location_id">Location</th>
                <th class="sortable" data-sort="quantity">Quantity</th>
                <th>Select</th>
            </tr>
            </thead>

            <tbody></tbody>

        </table>

    </div>

    <footer class="panel-footer clearfix text-center">

        {{-- Grid: Pagination --}}
        <div id="inventory-stocks-pagination" data-grid="inventory-stocks"></div>

    </footer>

    @include('maintenance::work-orders.parts.inventory.stocks.grid.templates.no-results')
    @include('maintenance::work-orders.parts.inventory.stocks.grid.templates.results')
    @include('maintenance::work-orders.parts.inventory.stocks.grid.templates.pagination')
    @include('maintenance::work-orders.parts.inventory.stocks.grid.templates.filters')

</section>

<script>

    $(function()
    {
        $.datagrid('inventory-stocks', '#inventory-stocks-results', '#inventory-stocks-pagination', '#inventory-stocks-filters');
    });

</script>