@extends('maintenance::layouts.admin')

@section('header')
    <h1>{{ $title }}</h1>
@stop

@section('breadcrumb')
    <li>
        <a href="{{ route('maintenance.admin.archive.index') }}">
            <i class="fa fa-archive"></i>
            Archive
        </a>
    </li>
@stop

@section('content')

    <div class="alert alert-info">
        <p>The <b>Archive</b> is where all records will stay when they are deleted.</p>

        <p>
            Record in the archive:
        <ul>
            <li>Can be permanently deleted</li>
            <li>Can be restored</li>
            <li>Have no expiry date</li>
            <li>Can be viewed and/or modified</li>
        </ul>
        </p>
    </div>

@stop