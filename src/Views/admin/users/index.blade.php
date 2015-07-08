@extends('maintenance::layouts.admin')

@section('title', 'Users')

@section('content')

    @include('maintenance::admin.users.grid.index')

@stop
