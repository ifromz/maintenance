@extends('layouts.main')

@section('title', 'Work Orders')

@section('content')

    @decorator('navbar', $navbar)

    {!! $workOrders !!}

@stop
