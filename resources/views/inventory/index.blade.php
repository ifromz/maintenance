@extends('layouts.main')

@section('title', 'Inventory')

@section('content')

    @decorator('navbar', $navbar)

    {!! $inventory !!}

@stop
