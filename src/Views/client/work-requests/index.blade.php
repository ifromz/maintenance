@extends('maintenance::layouts.client')

@section('title', 'Work Requests')

@section('content')

    @include('maintenance::client.work-requests.grid.index')

@stop
