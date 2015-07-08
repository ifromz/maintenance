@extends('maintenance::layouts.main')

@section('header')
    <h1>{{ $title }}</h1>
@stop

@section('breadcrumb')
    <li>
        <i class="fa fa-minus-circle"></i>
        Permission Denied
    </li>
@stop
