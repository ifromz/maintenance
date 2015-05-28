@extends('maintenance::layouts.main')

@section('styles')
    <link href="{{ URL::to('assets/css/daterangepicker-bs3.css') }}" rel="stylesheet">
@stop

@section('content')

    {{-- Grid --}}
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

                            @section('grid.actions')

                                <li class="danger disabled">
                                    <a data-grid-bulk-action="delete" data-toggle="tooltip" data-target="modal-confirm" data-original-title="{{{ trans('action.bulk.delete') }}}">
                                        <i class="fa fa-trash-o"></i> <span class="visible-xs-inline">{{{ trans('action.bulk.delete') }}}</span>
                                    </a>
                                </li>

                                <li class="dropdown">
                                    <a href="#" data-grid-exporter class="dropdown-toggle tip" data-toggle="dropdown" role="button" aria-expanded="false" data-original-title="{{{ trans('action.export') }}}">
                                        <i class="fa fa-download"></i> <span class="visible-xs-inline">{{{ trans('action.export') }}}</span>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a data-download="pdf"><i class="fa fa-file-pdf-o"></i> PDF</a></li>
                                        <li><a data-download="csv"><i class="fa fa-file-excel-o"></i> CSV</a></li>
                                        <li><a data-download="json"><i class="fa fa-file-code-o"></i> JSON</a></li>
                                    </ul>
                                </li>

                                @yield('grid.actions.create')

                            @show

                        </ul>

                        {{-- Grid: Filters --}}
                        <form class="navbar-form navbar-right" method="post" accept-charset="utf-8" data-search data-grid="main" role="form">

                            <div class="input-group">

                                <span class="input-group-btn">

                                    @section('grid.filters')

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

                                    @show
                                </span>

                                <input class="form-control" name="filter" type="text" placeholder="Search">

                                <span class="input-group-btn">

                                    <button class="btn btn-default" type="submit">
                                        <span class="fa fa-search"></span>
                                    </button>

                                    <button class="btn btn-default" data-grid="main" data-reset>
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

                <div id="data-grid_applied" class="btn-group" data-grid="main"></div>

            </div>

        </div>

        {{-- Grid: Table --}}
        <div class="table-responsive">

            @yield('grid.table')

        </div>

        <footer class="panel-footer clearfix">

            {{-- Grid: Pagination --}}
            <div id="data-grid_pagination" data-grid="main"></div>

        </footer>

        @yield('grid.results')

    </section>

@stop

@section('scripts')

    <script src="{{ URL::to('assets/cartalyst/data-grid/js/data-grid.js') }}"></script>
    <script src="{{ URL::to('assets/cartalyst/data-grid/js/underscore.js') }}"></script>

    <script src="{{ URL::to('assets/js/daterangepicker.js') }}"></script>

    <script>

        $(function()
        {
            $.datagrid('main', '.results', '.pagination', '.filters');
        });

    </script>

@stop
