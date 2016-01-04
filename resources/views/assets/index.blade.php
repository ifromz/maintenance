@extends('layouts.main')

@section('title', 'All Assets')

@section('content')

    @decorator('navbar', $navbar)

    {!! $assets !!}

@stop
