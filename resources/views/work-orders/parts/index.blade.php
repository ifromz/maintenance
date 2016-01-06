@extends('layouts.main')

@section('title', 'Work Order Parts')

@section('content')

    <h2>Parts Added</h2>

    {!! $parts !!}

    <h2>Inventory</h2>

    {!! $inventory !!}

@stop
