@extends('maintenance::layouts.main')

@section('title', 'Work Order Parts')

@section('content')

    <h2>Parts Added</h2>

    {{-- Parts Grid --}}
    <section class="panel panel-default panel-grid">

        {{-- Grid: Header --}}
        <header class="panel-heading">

            <nav class="navbar navbar-default navbar-actions">

                <div class="container-fluid">

                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#actions">
                            <span class="fa fa-bars"></span>
                        </button>
                    </div>

                    {{-- Grid: Actions --}}
                    <div class="collapse navbar-collapse" id="actions">

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
                        <form class="navbar-form navbar-right" method="post" accept-charset="utf-8" data-search data-grid="parts" role="form">

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

                                <button data-toggle="tooltip" data-original-title="Refresh" class="btn btn-default" data-grid="parts" data-reset>
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

                <div id="parts-filters" class="btn-group" data-grid="parts"></div>

            </div>

        </div>

        {{-- Grid: Table --}}
        <div class="table-responsive">

            <table id="parts-results" class="table table-hover" data-source="{{ route('maintenance.api.v1.work-orders.parts.grid', [$workOrder->id]) }}" data-grid="parts">

                <thead>
                <tr>
                    <th class="sortable" data-sort="inventory_id">ID</th>
                    <th>SKU</th>
                    <th class="sortable" data-sort="name">Name</th>
                    <th class="sortable" data-sort="location_id">Location</th>
                    <th>Quantity Taken</th>
                    <th>Date Taken</th>
                    <th>Put Back</th>
                </tr>
                </thead>

                <tbody></tbody>

            </table>

        </div>

        <footer class="panel-footer clearfix text-center">

            {{-- Grid: Pagination --}}
            <div id="parts-pagination" data-grid="parts"></div>

        </footer>

        @include('maintenance::work-orders.parts.grid.no-results')
        @include('maintenance::work-orders.parts.grid.results')
        @include('maintenance::work-orders.parts.grid.pagination')
        @include('maintenance::work-orders.parts.grid.filters')


    </section>

    <h2>Inventory</h2>

    {{-- Inventory Grid --}}
    <section class="panel panel-default panel-grid">

        {{-- Grid: Header --}}
        <header class="panel-heading">

            <nav class="navbar navbar-default navbar-actions">

                <div class="container-fluid">

                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#actions">
                            <span class="fa fa-bars"></span>
                        </button>
                    </div>

                    {{-- Grid: Actions --}}
                    <div class="collapse navbar-collapse" id="actions">

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
                        <form class="navbar-form navbar-right" method="post" accept-charset="utf-8" data-search data-grid="inventory" role="form">

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

                                    <button data-toggle="tooltip" data-original-title="Refresh" class="btn btn-default" data-grid="inventory" data-reset>
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

                <div id="inventory-filters" class="btn-group" data-grid="inventory"></div>

            </div>

        </div>

        {{-- Grid: Table --}}
        <div class="table-responsive">

            <table id="inventory-results" class="table table-hover" data-source="{{ route('maintenance.api.v1.work-orders.parts.inventory.grid', [$workOrder->id]) }}" data-grid="inventory">

                <thead>
                <tr>
                    <th class="sortable" data-sort="id">ID</th>
                    <th>SKU</th>
                    <th class="sortable" data-sort="name">Name</th>
                    <th class="sortable" data-sort="category_id">Category</th>
                    <th>Current Stock</th>
                    <th class="sortable" data-sort="created_at">Created At</th>
                    <th>Select</th>
                </tr>
                </thead>

                <tbody></tbody>

            </table>

        </div>

        <footer class="panel-footer clearfix text-center">

            {{-- Grid: Pagination --}}
            <div id="inventory-pagination" data-grid="inventory"></div>

        </footer>

        @include('maintenance::work-orders.parts.inventory.grid.no-results')
        @include('maintenance::work-orders.parts.inventory.grid.results')
        @include('maintenance::work-orders.parts.inventory.grid.pagination')
        @include('maintenance::work-orders.parts.inventory.grid.filters')

    </section>

    <script>

        $(function()
        {
            $.datagrid('parts', '#parts-results', '#parts-pagination', '#parts-filters');
            $.datagrid('inventory', '#inventory-results', '#inventory-pagination', '#inventory-filters');
        });

    </script>

@stop
