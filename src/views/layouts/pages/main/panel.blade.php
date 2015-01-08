@extends('maintenance::layouts.main')

@section('content')

    @yield('panel.extra.top')

    <div class="panel panel-default">

        @section('panel.head')

            <div class="panel-heading">

                @yield('panel.head.content')

            </div>

        @show

        @section('panel.body')

            <div id="resource-paginate" class="panel-body">

                @yield('panel.body.content')

            </div>

        @show

    </div>

    @yield('panel.extra.bottom')

@stop