@extends('layouts.main')

@section('title', 'Inventory Stocks')

@section('content')

    @decorator('navbar', $navbar)

    {!! $stocks !!}

@endsection
