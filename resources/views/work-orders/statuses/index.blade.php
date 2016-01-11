@extends('layouts.main')

@section('title', 'Statuses')

@section('content')

    @decorator('navbar', $navbar)

    {!! $statuses !!}

@endsection
