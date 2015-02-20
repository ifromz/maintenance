@extends('maintenance::layouts.main')

@section('header')
    <h1>{{ $title }}</h1>
@stop

@section('breadcrumb')
    <li>
        <a href="{{ route('maintenance.work-requests.index') }}">
            <i class="fa fa-exclamation-triangle"></i>
            Work Requests
        </a>
    </li>
    <li class="active">
        <i class="fa fa-plus-circle"></i>
        Create
    </li>
@stop

@section('content')

    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Create a new Work Request</h3>
            </div>
            <div class="panel-body">
                {{ Form::open(array('url'=>route('maintenance.work-requests.store'), 'class'=>'form-horizontal ajax-form-post clear-form')) }}

                @include('maintenance::work-requests.form')

                {{ Form::close() }}
            </div>
        </div>
    </div>

@stop