@extends('layouts.main')

@section('title', 'Assigned Work Orders')

@section('content')

    @decorator('navbar', $navbar)

    {!! $workOrders !!}

@endsection
