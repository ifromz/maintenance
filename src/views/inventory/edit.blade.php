@extends('maintenance::layouts.main')

@section('header')
    <h1>{{ $title }}</h1>
@stop

@section('breadcrumb')
    <li>
        <a href="{{ route('maintenance.inventory.index') }}">
            <i class="fa fa-dropbox"></i>
            Inventory
        </a>
    </li>
    <li>
        <a href="{{ route('maintenance.inventory.show', array($item->id)) }}">
            {{ $item->name }}
        </a>
    </li>
    <li class="active">
        <i class="fa fa-pencil-square-o"></i>
        Edit
    </li>
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

                <div class="form-group">
                    <label class="col-sm-2 control-label">Category</label>

                    <div class="col-md-4">
                        @include('maintenance::select.inventory-category', array(
                            'category_name' => $item->category->name,
                            'category_id'=> $item->category->id
                        ))
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Metric</label>

                    <div class="col-md-4">
                        @include('maintenance::select.metric', array(
                            'metric' => (($item->metric) ? $item->metric->id : NULL)
                        ))
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Name</label>

                    <div class="col-md-4">
                        {{ Form::text('name', $item->name, array('class'=>'form-control', 'placeholder'=>'Name')) }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Description</label>

                    <div class="col-md-4">
                        {{ Form::textarea('description', htmlspecialchars($item->description), array('class'=>'form-control', 'placeholder'=>'Description')) }}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        {{ Form::submit('Save', array('class'=>'btn btn-primary')) }}
                    </div>
                </div>

                {{ Form::close() }}
            </div>
        </div>

    </div>
@stop