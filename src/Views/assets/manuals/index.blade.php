@extends('maintenance::layouts.main')

@section('title', 'Asset Manuals')

@section('content')

    @include('maintenance::assets.manuals.grid.index', compact('asset'))

@stop
