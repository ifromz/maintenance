@extends('layouts.pages.main.panel')

@section('title', 'Add Attachments')

@section('panel.head.content')
    Add Attachments
@endsection

@section('panel.body.content')

    {!!
        Form::open([
            'url' => route('maintenance.work-orders.attachments.store', [$workOrder->id]),
            'files' => true,
        ])
    !!}

    <div class="form-group">
        {!! Form::file('files[]', ['multiple' => true]) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Save', ['class'=>'btn btn-success']) !!}
    </div>

@endsection
