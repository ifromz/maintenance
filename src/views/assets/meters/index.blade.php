@extends('maintenance::layouts.main')

@section('title', "All Meters for Asset: $asset->name")

@section('content')

    @include('maintenance::assets.meters.grid.index')

@stop
