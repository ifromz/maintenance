@extends('layouts.main')

@section('title', 'Asset Manuals')

@section('content')

    @include('assets.manuals.grid.index', compact('asset'))

@endsection
