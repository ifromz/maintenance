@extends('maintenance::layouts.main')

@section('title', 'All Assets')

@section('content')
    <h2>Assets</h2>

    @include('maintenance::assets.grid.index')
@stop
