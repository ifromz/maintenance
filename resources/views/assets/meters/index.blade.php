@extends('layouts.main')

@section('title', "All Meters for Asset: $asset->name")

@section('content')

    @include('assets.meters.grid.index')

@stop
