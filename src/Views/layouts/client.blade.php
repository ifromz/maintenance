@extends('maintenance::layouts.base')

@section('styles')
    {!! HTML::style('assets/stevebauman/maintenance/resources/bootstrap-daterangepicker/daterangepicker-bs3.css') !!}
@stop

@section('nav.left')
    <li class="{{ activeMenuLink('maintenance.client.work-requests') }}">
        <a href="{{ route('maintenance.client.work-requests.index') }}">
            <i class="fa fa-exclamation-triangle"></i> Work Requests
        </a>
    </li>
@stop

@section('scripts')

{!! HTML::script('assets/cartalyst/data-grid/js/data-grid.js') !!}
{!! HTML::script('assets/cartalyst/data-grid/js/underscore.js') !!}

        <!-- Bootstrap Date Range Picker -->
{!! HTML::script('assets/stevebauman/maintenance/resources/bootstrap-daterangepicker/daterangepicker.js') !!}

{!! HTML::script('assets/stevebauman/maintenance/js/grid.js') !!}

@stop
