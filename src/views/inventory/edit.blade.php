@extends('maintenance::layouts.main')

@section('header')
    <h1>{{ $title }}</h1>
@stop

@section('content')
    <div class="col-md-12">

        @include('maintenance::metrics.modals.create')

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Edit Item</h3>
            </div>
            <div class="panel-body">
                {{ Form::open(array(
                            'url'=>route('maintenance.inventory.update', array($item->id)),
                            'method'=>'PATCH',
                            'class'=>'form-horizontal ajax-form-post',
                        ))
                }}

               @include('maintenance::inventory.form', compact('item'))

                {{ Form::close() }}
            </div>
        </div>

    </div>
@stop