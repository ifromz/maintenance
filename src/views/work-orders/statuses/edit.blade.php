@extends('maintenance::layouts.pages.main.panel')

@section('panel.head.content')
    Edit Status
@stop

@section('panel.body.content')

    {!!
        Form::open([
            'url' => route('maintenance.work-orders.statuses.update', [$status->id]),
            'method' => 'PATCH',
            'class' => 'form-horizontal ajax-form-post clear-form'
        ])
    !!}

    <legend class="margin-top-10">Status Information</legend>

    <div class="form-group">
        <label class="col-sm-2 control-label">Name</label>

        <div class="col-md-4">
            {!! Form::text('name', $status->name, ['class'=>'form-control', 'placeholder'=>'ex. Awaiting Parts / Supplies']) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Color</label>

        <div class="col-md-4">
            @include('maintenance::select.color', [
                'color' => $status->color
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
