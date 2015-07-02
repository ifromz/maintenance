@extends('maintenance::layouts.admin')

@section('title', 'Archived Inventory Items')

@section('content')

    @include('maintenance::admin.archive.inventory.grid.index');

@stop
