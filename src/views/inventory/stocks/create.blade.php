@extends('maintenance::layouts.main')

@section('header')
	<h1>{{ $title }}</h1>
@stop

@section('breadcrumb')

@stop

@section('content')
    
    <div class="col-md-12">
        
        {{ HTML::script('packages/stevebauman/maintenance/js/inventory/create.js') }}
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Add Stock Location</h3>
            </div>
            <div class="panel-body">
            
            </div>
            
        </div>
    </div>
@stop