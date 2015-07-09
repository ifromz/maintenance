@extends('maintenance::layouts.main')

@section('title', 'Asset Images')

@section('content')

    @include('maintenance::assets.images.grid.index', compact('asset'))

@stop
