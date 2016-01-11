@extends('layouts.main')

@section('title', 'Work Requests')

@section('content')

    @decorator('navbar', $navbar)

    {!! $workRequests !!}

@endsection
