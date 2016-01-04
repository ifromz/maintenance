@extends('layouts.base')

@section('styles')
    {!! HTML::style('assets/bootstrap-daterangepicker/daterangepicker-bs3.css') !!}
@stop

@section('nav.left')
    <li class="{{ active()->route('maintenance.client.work-requests') }}">
        <a href="{{ route('maintenance.client.work-requests.index') }}">
            <i class="fa fa-exclamation-triangle"></i> Work Requests
        </a>
    </li>
@stop

@section('scripts')

{!! HTML::script('assets/cartalyst/data-grid/js/underscore.js') !!}

        <!-- Bootstrap Date Range Picker -->
{!! HTML::script('assets/bootstrap-daterangepicker/daterangepicker.js') !!}

@stop
