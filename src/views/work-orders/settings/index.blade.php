@extends('maintenance::layouts.main')

@section('header')
	<h1>{{ $title }}</h1>
@stop

@section('content')
	{{ HTML::link(route('maintenance.work-orders.categories.index'), 'Categories') }}
@stop