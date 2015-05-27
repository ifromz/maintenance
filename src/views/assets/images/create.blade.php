@extends('maintenance::layouts.pages.main.panel')

@section('panel.head.content')
    Add Asset Images
@stop

@section('panel.body.content')
    {!!
        Form::open([
            'url'=>route('maintenance.assets.images.store', [$asset->id]),
            'files' => true,
        ])
    !!}

    <div class="form-group">
        {!! Form::file('files[]', ['multiple' => true]) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Save', ['class'=>'btn btn-success']) !!}
    </div>
@stop
