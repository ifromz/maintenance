@extends('maintenance::layouts.pages.main.panel')

@section('panel.head.content')
    Viewing Image
@stop

@section('panel.body.content')
    <div class="col-md-12">
        <img class="img-responsive" src="{{ asset($image->file_path) }}">
    </div>
@stop
