@extends('layouts.main')

@section('title', 'Priorities')

@section('content')

    @decorator('navbar', $navbar)

    {!! $priorities !!}

@endsection
