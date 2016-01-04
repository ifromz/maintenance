@extends('layouts.admin')

@section('title', 'Archived Inventory Items')

@section('content')

    @include('admin.archive.inventory.grid.index');

@stop
