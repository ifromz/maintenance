@extends('maintenance::layouts.pages.main.panel')

@section('panel.head.content')
    Edit Meter
@stop

@section('panel.extra.top')
    @include('maintenance::assets.modals.meters.create')
@stop

@section('panel.body.content')

{!!
    Form::open([
        'url' => route('maintenance.assets.meters.update', [$asset->id, $meter->id]),
        'method' => 'PATCH',
        'class' => 'form-horizontal ajax-form-post'
    ])
!!}

<div class="form-group">
    <label class="col-sm-2 control-label" for="name">Name</label>

    <div class="col-md-4">
        {!! Form::text('name', $meter->name, ['class'=>'form-control']) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="name">Metric</label>

    <div class="col-md-4">
        @include('maintenance::select.metric', [
            'metric' => $meter->metric->id
        ])
    </div>
</div>


<div class="form-group">
    <div class="col-md-4 col-md-offset-2">
        {!! Form::submit('Save', ['class'=>'btn btn-primary']) !!}
    </div>
</div>

{!! Form::close() !!}

@stop
