@extends('layouts.pages.main.panel')

@section('title', "Edit Priority: $priority->name")

@section('panel.head.content')
    Edit Priority
@stop

@section('panel.body.content')
    {!!
        Form::open([
            'url' => route('maintenance.work-orders.priorities.update', [$priority->id]),
            'method' => 'PATCH',
            'class' => 'form-horizontal'
        ])
    !!}

    <legend class="margin-top-10">Priority Information</legend>

    <div class="form-group">
        <label class="col-sm-2 control-label">Name</label>

        <div class="col-md-4">
            {!! Form::text('name', $priority->name, ['class'=>'form-control', 'placeholder'=>'ex. Awaiting Parts / Supplies']) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Color</label>

        <div class="col-md-4">
            @include('select.color', [
                'color' => $priority->color
            ])
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {!! Form::submit('Save', ['class'=>'btn btn-primary']) !!}
        </div>
    </div>

    {!! Form::close() !!}
@stop
